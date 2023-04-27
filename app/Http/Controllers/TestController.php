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
            'words_percentage' => 'required',
            'words_per_minute' => 'required',
            'time' => 'required',
            'type' => 'required'
        ]);

        return Test::create([
            'user_id' => $request->user()->id,
            'words_percentage' => request('words_percentage'),
            'words_per_minute' => request('words_per_minute'),
            'time' => request('time'),
            'type' => request('type'),
        ]);
    }

    public function update(Request $request, $test)
    {


        $current_test = Test::find($test);
        $current_test->timestamps = false;
        $current_test->words_percentage = request('words_percentage');
        $current_test->words_per_minute = request('words_per_minute');
        $current_test->time = request('time');
        $current_test->save();
        return $current_test;
    }
}
