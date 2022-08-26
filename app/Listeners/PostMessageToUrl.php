<?php

namespace App\Listeners;

use App\Events\PublishEvent;
use App\Jobs\PublishedMessageJob;
use App\Models\Subscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class PostMessageToUrl
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PublishEvent  $event
     * @return void
     */
    public function handle(PublishEvent $message)
    {
        PublishedMessageJob::dispatch($message);
//        $topic = $message->topic;
//        $Newmessage = $message->payload;
//        $topicsUrl =  Subscription::where('topic',$message)->pluck('url');
//        foreach($topicsUrl as $url){
//            $response = Http::post($url, [
//                'topic'=> $topic,
//                'data' => $Newmessage,
//            ]);
//        }
    }
}
