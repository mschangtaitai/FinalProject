<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExamItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_exam_id',
        'item_id',
        'grade'
    ];
}
