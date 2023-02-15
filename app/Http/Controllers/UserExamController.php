<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExam;

class UserExamController extends Controller
{
    public function index() {
        return UserExam::all();
    }

    public function store()
    {
        request()->validate([
            'name' => 'required',
        ]);
    
        return UserExam::create([
            'name' => request('name'),
        ]);
    }
}
