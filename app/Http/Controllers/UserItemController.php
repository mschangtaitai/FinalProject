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

    public function week(Request $request, $week) {
        $user_id = $request->user()->id;

        $items = UserItem::where('user_id',$user_id)->get();

        $responseDay1 = collect([]);
        $responseDay2 = collect([]);
        $responseDay3 = collect([]);
        $responseDay4 = collect([]);
        $responseDay5 = collect([]);
        $responseDay6 = collect([]);
        $responseDay7 = collect([]);
        
        foreach ($items as $item) {
            $search = Item::where('week',$week)->where('id', $item->item_id)->first();
            if($search != null){
                if($search->day == 1){
                    $toAdd = collect([
                        'id' => $search->id,
                        'week' => $search->week,
                        'day' => $search->day,
                        'tool' => $search->tool,
                        'name' => $search->name,
                        'type' => $search->type,
                        'progression' => $item->progression,

                    ]);
                    $responseDay1->push($toAdd);
                }
                elseif($search->day == 2){
                    $toAdd = collect([
                        'id' => $search->id,
                        'week' => $search->week,
                        'day' => $search->day,
                        'tool' => $search->tool,
                        'name' => $search->name,
                        'type' => $search->type,
                        'progression' => $item->progression,

                    ]);
                    $responseDay2->push($toAdd);
                }
                elseif($search->day == 3){
                    $toAdd = collect([
                        'id' => $search->id,
                        'week' => $search->week,
                        'day' => $search->day,
                        'tool' => $search->tool,
                        'name' => $search->name,
                        'type' => $search->type,
                        'progression' => $item->progression,

                    ]);
                    $responseDay3->push($toAdd);
                }
                elseif($search->day == 4){
                    $toAdd = collect([
                        'id' => $search->id,
                        'week' => $search->week,
                        'day' => $search->day,
                        'tool' => $search->tool,
                        'name' => $search->name,
                        'type' => $search->type,
                        'progression' => $item->progression,

                    ]);
                    $responseDay4->push($toAdd);
                }
                elseif($search->day == 5){
                    $toAdd = collect([
                        'id' => $search->id,
                        'week' => $search->week,
                        'day' => $search->day,
                        'tool' => $search->tool,
                        'name' => $search->name,
                        'type' => $search->type,
                        'progression' => $item->progression,

                    ]);
                    $responseDay5->push($toAdd);
                }
                elseif($search->day == 6){
                    $toAdd = collect([
                        'id' => $search->id,
                        'week' => $search->week,
                        'day' => $search->day,
                        'tool' => $search->tool,
                        'name' => $search->name,
                        'type' => $search->type,
                        'progression' => $item->progression,

                    ]);
                    $responseDay6->push($toAdd);
                }
                elseif($search->day == 7){
                    $toAdd = collect([
                        'id' => $search->id,
                        'week' => $search->week,
                        'day' => $search->day,
                        'tool' => $search->tool,
                        'name' => $search->name,
                        'type' => $search->type,
                        'progression' => $item->progression,

                    ]);
                    $responseDay7->push($toAdd);
                }
            }
        }

        $days = collect([
            'id' => $week,
            'days' => [
                collect([
                    'id' => '1',
                    'name' => 'Dia 1',
                    'exercises' => $responseDay1
                ]),
                collect([
                    'id' => '2',
                    'name' => 'Dia 2',
                    'exercises' => $responseDay2
                ]),
                collect([
                    'id' => '3',
                    'name' => 'Dia 3',
                    'exercises' => $responseDay3
                ]),
                collect([
                    'id' => '4',
                    'name' => 'Dia 4',
                    'exercises' => $responseDay4
                ]),
                collect([
                    'id' => '5',
                    'name' => 'Dia 5',
                    'exercises' => $responseDay5
                ]),
                collect([
                    'id' => '6',
                    'name' => 'Dia 6',
                    'exercises' => $responseDay6
                ]),
                collect([
                    'id' => '7',
                    'name' => 'Dia 7',
                    'exercises' => $responseDay7
                ]),
            ],
        ]);

        return $days;
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
