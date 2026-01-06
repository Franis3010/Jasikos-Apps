<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use App\Models\{Design, DesignMedia};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DesignMediaController extends Controller
{
      public function store(Request $request, Design $design)
    {
        $this->ensureOwner($design);

        $data = $request->validate([
            'file' => ['required','file','max:8192'], // 8MB
        ]);

        $file = $data['file'];
        $mime = $file->getMimeType();
        $type = str_starts_with($mime, 'image/') ? 'image' : 'video';

        $path = $file->store("designs/{$design->id}", 'public');

        $media = $design->media()->create([
            'type'       => $type,
            'path'       => $path,
            'sort_order' => $design->media()->max('sort_order') + 1,
        ]);

        return back()->with('success', 'Media Added.')->with('new_media_id', $media->id);
    }

    public function destroy(DesignMedia $media)
    {
        // pastikan owner
        $this->ensureOwner($media->design);

        if ($media->path) Storage::disk('public')->delete($media->path);
        $media->delete();

        return back()->with('success', 'Media is Deleted.');
    }

    private function ensureOwner(Design $design): void
    {
        if ($design->designer_id !== auth()->user()->designer->id) {
            abort(403);
        }
    }
}
