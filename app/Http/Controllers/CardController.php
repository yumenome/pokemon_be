<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardStoreRequest;
use App\Http\Resources\CardResource;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $cards = CardResource::collection(Card::query()->where('is_active', true)->orderBy('created_at', 'desc')->get());
        $cards = CardResource::collection(Card::query()->orderBy('created_at', 'desc')->get());
        // $cards = Card::all();

        return $cards;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(),[
            'name' => 'require|string|max: 255',
            'price' => 'require|string|max: 255',
            'img' => 'string', 'required',
            'total' => 'require',
            'type' => 'require',
            'rarity' => 'require',
        ]);
        // . time() . '-' .
        $card = new Card;
        if($request->hasFile('img')){
            $img_name = 'card_images/'  .$request->img->getClientOriginalName();
            $request->img->move(public_path('storage/card_images'), $img_name);
            $card->img = $img_name;
        }
        $card->user_id = auth()->user()->id;
        $card->name = $request->name;
        $card->price = $request->price;
        $card->per_price = $request->price;
        $card->total = $request->total;
        $card->type = $request->type;
        $card->rarity = $request->rarity;

        $card->save();

        return response()->json([
            'message' => "successfully created."
        ],200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Card $card)
    {
        return new CardResource($card);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Card $card)
    {

        if($request->hasFile('img')){

                if( !is_null($card->img)){
                    Storage::disk('card_images')->delete($card->img);
                }
                $img_name = 'card_images/' . time() . '-' . $request->img->getClientOriginalName();
                $request->img->move(public_path('storage/card_images'), $img_name);
                $card->img = $img_name;
        }

        $card->user_id = auth()->user()->id;
        $card->name = $request->name;
        $card->price = $request->price;
        $card->total = $request->total;
        $card->is_active = $request->is_active;
        $card->type = $request->type;
        $card->rarity = $request->rarity;

        // if($request->img){

        //     $storage = Storage::disk('public');

            // if($storage->exists($card->img)){
            //     $storage->delete($card->img);
            // }

        //     $img_name = 'card_images/' . time() . '-' . $request->img->getClientOriginalName();
        //     $card->img = $img_name;
        //     $storage->put($img_name, file_get_contents($request->img));
        // }

        $card->save();


        return response()->json([
            'message' => "successfully updated."
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $card = Card::find($id);
        $card->delete();

        return response()->json([
            'message' => "successfully deleted."
        ],200);
    }

}
