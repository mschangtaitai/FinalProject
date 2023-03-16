<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserItem;
use App\Models\Item;

class UserItemController extends Controller
{
    public function dashboard(Request $request) {
        $user_id = $request->user()->id;

        $items = UserItem::where('user_id',$user_id)->get();

        $week1Total = 0;
        foreach ($items as $item) {
            $search = Item::where('week','1')->where('id', $item->item_id)->first();
            if($search != null and $item->progression == '2'){
                $week1Total++;
            }
        }

        $week2Total = 0;
        foreach ($items as $item) {
            $search = Item::where('week','2')->where('id', $item->item_id)->first();
            if($search != null and $item->progression == '2'){
                $week2Total++;
            }
        }

        $week3Total = 0;
        foreach ($items as $item) {
            $search = Item::where('week','3')->where('id', $item->item_id)->first();
            if($search != null and $item->progression == '2'){
                $week3Total++;
            }
        }

        $week4Total = 0;
        foreach ($items as $item) {
            $search = Item::where('week','4')->where('id', $item->item_id)->first();
            if($search != null and $item->progression == '2'){
                $week4Total++;
            }
        }

        $response = collect([
            ['id' => 1, 'name' => 'week 1', 'progression' => $week1Total],
            ['id' => 2, 'name' => 'week 2', 'progression' => $week2Total],
            ['id' => 3, 'name' => 'week 3', 'progression' => $week3Total],
            ['id' => 4, 'name' => 'week 4', 'progression' => $week4Total]
        ]);

        return $response;
    }

    public function store(Request $request)
    {
        request()->validate([
            'item_id' => 'required',
            'value' => 'required',
            'progression' => 'required',
        ]);
    
        return UserItem::create([
            'user_id' => $request->user()->id,
            'item_id' => request('item_id'),
            'value' => request('value'),
            'progression' => request('progression'),
        ]);
    }
}
