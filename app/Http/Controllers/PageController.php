<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function show(string $slug)
    {
        $page = config('pages.' . $slug);

        abort_unless($page, 404);

        return view('pages.show', compact('page'));
    }
}