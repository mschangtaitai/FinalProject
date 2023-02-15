<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index() {
        return Exam::all();
    }

    public function show($id) {
        return Exam::with('items')->findOrFail($id);
    }


    public function store()
    {
        request()->validate([
            'name' => 'required',
        ]);
    
        return Exam::create([
            'name' => request('name'),
        ]);
    }
}
