<?php

namespace App\Console\Commands;

use App\Models\Images;
use App\Models\ImagesParse;
use App\Models\Logs;
use App\Models\Parse;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Vedmant\FeedReader\Facades\FeedReader;

class ParseTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
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
