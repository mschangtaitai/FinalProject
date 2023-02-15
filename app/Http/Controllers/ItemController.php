<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index() {
        return Item::all();
    }

    public function store()
    {
        request()->validate([
            'name' => 'required',
            'value' => 'required'
        ]);
    
        return Item::create([
            'name' => request('name'),
            'value' => request('value'),
        ]);
    }
}
