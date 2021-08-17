<?php

namespace App\Jobs;

use App\Models\Images;
use App\Models\ImagesParse;
use App\Models\Logs;
use App\Models\Parse;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Vedmant\FeedReader\Facades\FeedReader;

class ParseTest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Request $request)
    {
        $f = FeedReader::read('http://static.feed.rbc.ru/rbc/logical/footer/news.rss');

        Images::truncate();
        Parse::truncate();
        ImagesParse::truncate();

        foreach ($f->get_items() as $item){
            $parse = Parse::create([
                'name' => $item->get_title(),
                'url' => $item->get_link(),
                'short_description' => $item->get_description(),
                'author' => $item->get_author()->email ?? null
            ]);

            $media_group = $item->get_item_tags('', 'enclosure');
            if($media_group){
                foreach ($media_group as $media){
                    $file = $media['attribs']['']['url'];
                    $image = Images::create([
                        'images_url' => $file
                    ]);
                    $parse->images()->attach($image);
                }
            }
        }

        $logs = new Logs();
        $logs->dateTime = Carbon::now();
        $logs->requestMethod = $request->method();
        $logs->requestUrl = $request->url();
        $logs->httpCode = response($f)->getStatusCode();
        $logs->responseBody = response($f)->getContent();
        $logs->save();
    }
}
