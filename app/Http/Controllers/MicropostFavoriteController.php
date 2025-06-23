<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MicropostFavoriteController extends Controller
{
    public function store(string $id)
    {
        \Auth::user()->favorite(intval($id));
        return back();
    }

    public function destroy(string $id)
    {
        \Auth::user()->unfavorite(intval($id));
        return back();
    }
}