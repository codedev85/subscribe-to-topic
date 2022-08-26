<?php

namespace App\Http\Controllers\Api;

use App\Events\PublishEvent;
use App\Http\Controllers\Controller;
use App\Jobs\PublishedMessageJob;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Message as PublishedMessage;

class Message extends Controller
{
    //
    public function publish(Request $request ,$topic){

      $this->validateRequest($request);

      $findTopic = Topic::where('name',$topic)->first();
      $subExist =  Subscription::where('topic',$topic)->first();

      if(is_null($findTopic)){
          return response()->json(['error'=> 'Topic is not found']);
      }

      if(!$subExist){
        return response()->json(['error'=>'No subscriber yet to this topic']);
      }

      $message = new PublishedMessage();
      $message->topic = $topic;
      $message->payload = $request['payload'];
      $message->save();

      if($message){
          PublishedMessageJob::dispatch($message);
          return response()->json(['status' => true , 'data' => $message]);
      }

    }


    protected function validateRequest($data){
        $data->validate([
            'payload'=> 'required'
        ]);
    }
}
