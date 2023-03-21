<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserItem;
use App\Models\Item;

class UserItemController extends Controller
{

    public function index(Request $request) {
        return UserItem::all();
    }

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

    public function week(Request $request, $week) {
        $user_id = $request->user()->id;

        $user_items = UserItem::with('item')->where('user_id',$user_id)->get();
        $user_items = $user_items->where('item.week', $week)->map(function ($user_item) {
            return collect([
                'id' => $user_item->id,
                'itemId'=> $user_item->item->id,
                'week' => $user_item->item->week,
                'day' => $user_item->item->day,
                'tools' => $user_item->item->tools,
                'name' => $user_item->item->name,
                'type' => (int)$user_item->item->type,
                'progression' => (int)$user_item->progression,
            ]);
        });

        $exercises = collect([1,2,3,4,5,6,7])->map(function ($day) use ($user_items) {
            return collect([
                'id' => $day,
                'name' => 'Día ' . $day,
                'exercises' => $user_items->where('day', $day)
            ]);
        });

        $week = collect([
            'id' => (int)$week,
            'days' => $exercises
        ]);

        return $week;
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
    
    public function progress(Request $request){
        $userItem = UserItem::where('id',$request->id)->first();
        echo $userItem;
        $userItem->progression = (string)($userItem->progression + 1);
        $userItem->value = $request->value;
        $userItem->save();

        return $userItem;
    }

    public function delete($id){
        $user_item = UserItem::where('id',$id)->delete();
        return $user_item
    }
}
