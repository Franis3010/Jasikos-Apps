<?php

namespace App\Http\Controllers;

use App\Models\Designer;

class PublicDesignerController extends Controller
{
   public function show($id)
    {
        $designer = Designer::with(['user'])
            ->with(['designs' => fn($q) => $q->where('status','published')->latest()])
            ->withCount('ratings')
            ->withAvg('ratings','stars')
            ->findOrFail($id);

        // Handle nilai null supaya aman
        $avg = $designer->ratings_avg_stars ?? 0;
        $cnt = $designer->ratings_count ?? 0;

        return view('designer.public', compact('designer', 'avg', 'cnt'));
    }
}
