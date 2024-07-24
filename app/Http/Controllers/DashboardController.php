<?php

namespace App\Http\Controllers;

use App\Models\UniqueUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $urls = UniqueUrl::where('user_id', auth()->id())->get();
        return view('dashboard', compact('urls'));
    }

    public function generateUrl()
    {
        $url = Str::random(10);
        while (UniqueUrl::where('url', $url)->exists()) {
            $url = Str::random(10);
        }

        UniqueUrl::create([
            'url' => $url,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'New Event URL generated successfully');
    }
}