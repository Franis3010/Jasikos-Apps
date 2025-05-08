<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;

        // If image is uploaded
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('services', 'public');
        } else {
            // Copy default image as [name].png
            $defaultPath = public_path('services/default.png');
            $targetFileName = $validated['name'] . '.png';
            $targetPath = public_path('services/' . $targetFileName);

            if (file_exists($defaultPath)) {
                copy($defaultPath, $targetPath);
                $imagePath = 'services/' . $targetFileName;
            }
        }

        Service::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'min_price' => $validated['min_price'],
            'max_price' => $validated['max_price'],
            'image' => $imagePath, // either uploaded or copied
        ]);

        return redirect()->route('service.adminshow')->with('success', 'Service created successfully!');
    }
    // Show a single service
    public function show($id)
    {
        $service = Service::findOrFail($id);
        return view('services.show', compact('service'));
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('services.serviceedit', compact('service')); // Change to 'services.serviceedit'
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $service = Service::findOrFail($id);
        $service->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'min_price' => $request->min_price,
            'max_price' => $request->max_price,
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('services', 'public');
            $service->update(['image' => $imagePath]);
        }

        return redirect()->route('service.edit', $service->id)->with('success', 'Service updated successfully.');
    }

    public function browseForUser(Request $request)
    {
        $query = Service::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $services = $query->get();

        return view('home', compact('services'));
    }

    public function adminShow()
    {
        $services = Service::all();
        return view('serviceadminpage', compact('services'));
    }

    public function destroy($id)
    {
        // Find the service by its ID
        $service = Service::findOrFail($id);

        // Delete the image if it exists
        if ($service->image && file_exists(public_path('storage/' . $service->image))) {
            unlink(public_path('storage/' . $service->image));
        }

        // Delete the service record
        $service->delete();

        // Redirect back with a success message
        return redirect()->route('service.adminshow')->with('success', 'Service deleted successfully');
    }
}