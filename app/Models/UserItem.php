<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;


class UserItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'value',
        'progression',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

}
