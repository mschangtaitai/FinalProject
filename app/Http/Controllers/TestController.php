<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;

class TestController extends Controller
{

    public function index() {
        return Test::all();
    }

    public function store(Request $request)
    {
    
        request()->validate([
            'words' => 'required',
            'words_per_minute' => 'required',
            'type' => 'required'
        ]);

        return Test::create([
            'user_id' => $request->user()->id,
            'words' => request('words'),
            'words_per_minute' => request('words_per_minute'),
            'type' => request('type'),
        ]);
    }
}
