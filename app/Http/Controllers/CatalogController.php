<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Design, Category};

class CatalogController extends Controller
{
    // Kumpulkan data sekali, dipakai oleh 2 method
    protected function getCatalogData(Request $request): array
    {
        $q       = $request->query('q');
        $catSlug = $request->query('category');
        $sort    = $request->query('sort'); // price_asc|price_desc|newest

        $designs = Design::with(['categories','designer.user'])
            ->where('status','published')
            ->when($q, fn($qr) => $qr->where('title','like',"%{$q}%"))
            ->when($catSlug, fn($qr) =>
                $qr->whereHas('categories', fn($c) => $c->where('slug', $catSlug))
            )
            ->when($sort==='price_asc',  fn($qr) => $qr->orderBy('price','asc'))
            ->when($sort==='price_desc', fn($qr) => $qr->orderBy('price','desc'))
            ->when(!$sort || $sort==='newest', fn($qr) => $qr->latest())
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return compact('designs','categories','q','catSlug','sort');
    }

    // Versi publik (frontend)
    public function index(Request $request)
    {
        $data = $this->getCatalogData($request);
        return view('catalog.index', $data);
    }

    // Versi dashboard customer
    public function indexCustomer(Request $request)
    {
        $data = $this->getCatalogData($request);
        return view('customer.catalog.index', $data);
    }

    public function show($slug)
    {
        $design = Design::with(['categories','media','designer.user'])
            ->where('slug', $slug)
            ->where('status','published')
            ->firstOrFail();

        return view('catalog.show', compact('design'));
    }
}
