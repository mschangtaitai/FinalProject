<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamItem;
use App\Models\Exam;
use App\Models\Item;

class ExamItemController extends Controller
{

    public function store()
    {

        request()->validate([
            'exam_id' => 'required|exists:exams,id',
            'item_id' => 'required|exists:items,id'
        ]);
    
        return ExamItem::create([
            'exam_id' => request('exam_id'),
            'item_id' => request('item_id')
        ]);
    }
}
