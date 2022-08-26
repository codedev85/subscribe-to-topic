<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription as SubscriptToTopic;
use App\Models\Topic;

class Subscription extends Controller
{
    //
    public function subscribe(Request $request ,$topic){

         $this->validateResponse($request);
         $findTopic = Topic::where('name',$topic)->first();
         if(Is_null( $findTopic)){
             return response()->json(['error' => 'Topic Not found']);
         }
         $subscribe = new SubscriptToTopic();
         $subscribe->topic = $topic;
         $subscribe->url  = $request['url'];
         $subscribe->save();
         if($subscribe){
             return response()->json(['status' => true ,'data'=> $subscribe ], 200);
         }

    }

    protected function validateResponse($data){

        $data->validate([
            'url' =>  ['required','regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i']
        ]);
    }
}
