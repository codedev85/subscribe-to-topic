<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic as TP;

class Topic extends Controller
{
    //
    public function topic(Request $request){

        $this->validateResponse($request);
        $topic = new TP();
        $topic->name = $request['name'];
        $topic->save();

       if($topic){
           return response()->json(['status' => true ,'data'=> $topic ], 200);
       }

    }

    protected function validateResponse($data){

        $data->validate([
            'name'=> 'required|unique:topics'
           ]);
    }
}
