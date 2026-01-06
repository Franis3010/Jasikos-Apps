<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Design; // Assuming you have a Design model
use App\Models\Category; // Assuming you have a Category model
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DesignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designerId = auth()->user()->designer->id;
        $designs = Design::where('designer_id', $designerId)->latest()->paginate(12);
        return view('designer.designs.index', compact('designs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $categories = Category::orderBy('name')->get();
        return view('designer.designs.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $designerId = auth()->user()->designer->id;

        $data = $request->validate([
            'title'       => ['required','string','max:150'],
            'price'       => ['required','integer','min:1000'],
            'description' => ['nullable','string'],
            'status'      => ['required', Rule::in(['draft','published','archived'])],
            'categories'  => ['nullable','array'],
            'categories.*'=> ['integer','exists:categories,id'],
            'thumbnail'   => ['nullable','image','max:2048'],
        ]);

        // slug unik
        $base = Str::slug($data['title']);
        $slug = $base;
        $i = 1;
        while (Design::where('slug', $slug)->exists()) {
            $slug = $base.'-'.(++$i);
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('design_thumbs', 'public');
        }

        $design = Design::create([
            'designer_id' => $designerId,
            'slug'        => $slug,
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'price'       => $data['price'],
            'status'      => $data['status'],
            'thumbnail'   => $data['thumbnail'] ?? null,
            'is_featured' => false,
        ]);

        if (!empty($data['categories'])) {
            $design->categories()->sync($data['categories']);
        }

        return redirect()->route('designer.designs.edit', $design)->with('success','Desain Created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Design $design)
    {
         $this->ensureOwner($design);
        return view('designer.designs.show', compact('design'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Design $design)
    {
        $this->ensureOwner($design);
        $categories = Category::orderBy('name')->get();
        $selected = $design->categories()->pluck('category_id')->toArray();
        return view('designer.designs.edit', compact('design','categories','selected'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Design $design)
    {
          $this->ensureOwner($design);

        $data = $request->validate([
            'title'       => ['required','string','max:150'],
            'price'       => ['required','integer','min:1000'],
            'description' => ['nullable','string'],
            'status'      => ['required', Rule::in(['draft','published','archived'])],
            'categories'  => ['nullable','array'],
            'categories.*'=> ['integer','exists:categories,id'],
            'thumbnail'   => ['nullable','image','max:2048'],
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($design->thumbnail) Storage::disk('public')->delete($design->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('design_thumbs', 'public');
        }

        $design->update([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'price'       => $data['price'],
            'status'      => $data['status'],
            'thumbnail'   => $data['thumbnail'] ?? $design->thumbnail,
        ]);

        $design->categories()->sync($data['categories'] ?? []);

        return back()->with('success','Desain Updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Design $design)
    {
        $this->ensureOwner($design);

        // hapus file
        if ($design->thumbnail) Storage::disk('public')->delete($design->thumbnail);
        foreach ($design->media as $m) {
            if ($m->path) Storage::disk('public')->delete($m->path);
            $m->delete();
        }
        $design->categories()->detach();

        $design->delete();

        return redirect()->route('designer.designs.index')->with('success','Desain Deleted.');
    }
    private function ensureOwner(Design $design): void
    {
        if ($design->designer_id !== auth()->user()->designer->id) {
            abort(403);
        }
    }
}
