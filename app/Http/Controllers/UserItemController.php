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

        $user_items = UserItem::with('item')->where('user_id',$user_id)->get();

        
        $totals = collect(['1' => 0,'2' => 0,'3' => 0,'4' => 0]);
        $user_items->map(function ($user_item) use ($user_items,$totals) {
            if($user_item->progression == '3'){
                if($user_item->item->week == '1') {
                    $totals->put('1', $totals->get('1') + 1);
                }
                elseif($user_item->item->week == '2') {
                    $totals->put('2', $totals->get('2') + 1);
                }
                elseif($user_item->item->week == '3') {
                    $totals->put('3', $totals->get('3') + 1);
                }
                elseif($user_item->item->week == '4') {
                    $totals->put('4', $totals->get('4') + 1);
                }
            }
        });
        
        $dashboard = collect(['1','2','3','4'])->map( function ($week) use ($totals) {
            return collect([
                'id' => $week, 'name' => 'week ' . $week, 'progression' => $totals->get($week),
            ]);
        });
        
        return $dashboard;
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
                'exercises' => $user_items->where('day', $day)->values()
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
        $oldItem = clone $userItem;
        $userItem->progression = (string)($userItem->progression + 1);
        $userItem->value = $request->value;
        $userItem->save();
        $userItem->progression = (int)($userItem->progression);
        $oldItem->progression = (int)($oldItem->progression);


        return collect([
            'old' => $oldItem,
            'new' => $userItem
        ]);
    }

    public function delete($id){
        $user_item = UserItem::where('id',$id)->delete();
        return $user_item;
    }

    public function assign(Request $request){

        $items = Item::all();

        $items->map( function ($item) use ($request) {
            $user_item = UserItem::create([
                'user_id' => $request->user()->id,
                'item_id' => $item->id,
                'value' => 0,
                'progression' => "0",
            ]);

        });

        return 'User Items created for current user!';
    }

    public function final_availability(Request $request) {
        $user_id = $request->user()->id;

        $user_items = UserItem::with('item')->where('user_id',$user_id)->get();
        $final_item = $user_items->where('item.week', 2)->where('item.day', 7)->sum('progression');

        if($final_item == 15) {
            return collect(['Available'=>TRUE]);
        }

        return collect(['Available'=>FALSE]);

    }
}
