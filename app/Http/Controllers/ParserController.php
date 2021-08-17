<?php

namespace App\Http\Controllers;

use App\Jobs\ParseTest;
use App\Models\Images;
use App\Models\Logs;
use App\Models\Parse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Vedmant\FeedReader\Facades\FeedReader;


class ParserController extends Controller
{
    public function parser(){
        ParseTest::dispatch()->delay(now()->addMinute(15));
    }
}
