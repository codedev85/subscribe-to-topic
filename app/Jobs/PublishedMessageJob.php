<?php

namespace App\Jobs;

use App\Events\PublishEvent;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class PublishedMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $message;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        //
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
           $topic = $this->message->topic;
           $message = $this->message->payload;
           $topicsUrl =  Subscription::where('topic',$topic)->pluck('url');
            foreach($topicsUrl as $url){
                $response = Http::post($url, [
                    'topic'=> $topic,
                    'data' => $message,
                ]);
            }

       //event(new PublishEvent($topic));
    }
}
