<?php

namespace App\Http\Controllers;

use App\Models\QtpGame;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class FileTestController extends Controller
{
    public function uploads(Request $request){

        $request->validate([
            'files'   => 'required',
            'files.*' => 'file|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $fails = [];

        if($request->hasFile('files')){
            foreach ($request->file('files') as $file) {
                $name = str_replace('.png', '',$file->getClientOriginalName());
                $name = str_replace(' ', '', $name);
                $game = QtpGame::where('gameid', $name)->first();

                // if($game){
                    $filename =  $name . '.' . $file->getClientOriginalExtension();
                    Image::make($file)->resize(150,150, function ($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode('webp', 70)->save(public_path('/media/game/'.$filename));


                    // $game->image = 'media/game/'. $filename;

                    // $game->save();
                // }else{
                //     $fails[] = ['game' => "$name is missing"];
                // }
            }
        }

        if(count($fails) > 0){
            return response()->json([
                'fails image upload' => $fails,
            ]);
        }

        return back()->with('success', 'the image has been upload successfully');
    }

    public function wingo(){
        return view('wingo');
    }

    public function bet(Request $request)
    {
        $request->validate([
            'type'=>'required',
            'value'=>'required',
            'amount'=>'required|integer|min:1'
        ]);

        $user = auth()->user();

        if($user->balance < $request->amount){
            return response()->json(['error'=>'Insufficient balance'],422);
        }

        $user->decrement('balance', $request->amount);

        DB::table('wingo_bets')->insert([
            'user_id'=>$user->id,
            'type'=>$request->type,
            'value'=>$request->value,
            'amount'=>$request->amount,
            'created_at'=>now()
        ]);

        return response()->json(['success'=>true]);
    }

    public function history()
    {
        return DB::table('wingo_bets')
            ->where('user_id', auth()->id())
            ->latest()
            ->limit(20)
            ->get();
    }

    public function predict()
    {
        $numbers = DB::table('wingo_rounds')
            ->latest()->take(10)->pluck('number');

        $avg = $numbers->avg();

        return response()->json([
            'prediction' => $avg >= 5 ? 'Big' : 'Small'
        ]);
    }
}
