<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request) {

        return Item::all();
    }

    public function store()
    {
        request()->validate([
            'week' => 'required',
            'day' => 'required',
            'time' => 'required',
            'name' => 'required',
            'objective' => 'required',
            'instructions' => 'required',
            'file_path' => 'required',
            'type' => 'required',
        ]);
    
        return Item::create([
            'week' => request('week'),
            'day' => request('day'),
            'time' => request('time'),
            'tools' => request('tools'),
            'name' => request('name'),
            'objective' => request('objective'),
            'instructions' => request('instructions'),
            'file_path' => request('file_path'),
            'type' => request('type'),
        ]);
    }
}
