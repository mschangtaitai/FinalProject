<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
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
            'file' => 'required',
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
            'file_path' => request()->file('file')->store('files'),
            'type' => request('type'),
        ]);
    }

    public function get($id){
        $item = Item::where('id',$id)->first();
        $item->file_path = Storage::temporaryUrl(
            $item->file_path, now()->addMinutes(1)
        );
        $item->type = (int)$item->type;
        return $item;
    }

    public function delete($id){
        $item = Item::where('id',$id)->delete();
    }
}
