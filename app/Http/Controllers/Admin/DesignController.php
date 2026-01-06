<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Design, DesignMedia};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class DesignController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $designs = Design::with(['designer.user','categories'])
            ->when($status, fn($q)=>$q->where('status',$status))
            ->latest()->paginate(20)->withQueryString();

        return view('admin.designs.index', compact('designs','status'));
    }

    public function show(Design $design)
    {
        $design->load(['designer.user','media','categories']);
        return view('admin.designs.show', compact('design'));
    }

    public function update(Request $request, Design $design)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['draft','published','archived'])],
            'is_featured' => ['nullable','boolean'],
        ]);
        $design->update([
            'status' => $data['status'],
            'is_featured' => (bool)($data['is_featured'] ?? false),
        ]);
        return back()->with('success','Design updated.');
    }

    public function destroy(Design $design)
    {
        foreach ($design->media as $m) {
            if ($m->path) Storage::disk('public')->delete($m->path);
        }
        $design->media()->delete();
        $design->categories()->detach();
        $design->delete();
        return redirect()->route('admin.designs.index')->with('success','Design deleted.');
    }
}
