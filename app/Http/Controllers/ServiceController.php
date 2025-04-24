<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    // Show a single service
    public function show($id)
    {
        $service = Service::findOrFail($id);
        return view('services.show', compact('service'));
    }

    // Show edit form
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('services.edit', compact('service'));
    }

    // Handle update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);

        $service = Service::findOrFail($id);
        $service->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('service.show', $id)->with('success', 'Service updated successfully.');
    }
}