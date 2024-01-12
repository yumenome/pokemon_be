<?php

namespace App\Http\Controllers;

use App\Models\Active;
use App\Models\Card;
use Illuminate\Http\Request;

class ActiveControlller extends Controller
{
    public function store(string $id){

        $user_id = auth()->user()->id;
        $card = Card::find($id);

        $active = Active::where('user_id', $user_id)
                        ->where('card_id', $id)->first();

        if($card->is_active === 1){

         if($active){
            $active->delete();
         }
            $card->is_active  = 0;
            $card->save();
            return response()->json([
                'message' => "inactive!"
            ],200);

        }else{
            $active= new Active();
            $active->user_id = $user_id;
            $active->card_id = $id;
            $active->save();

            $card->is_active = 1;
            $card->save();

            return response()->json([
                'message' => "active!"
            ],200);
        };



    }
}
