<?php

namespace App\Http\Controllers\Api;

use App\Models\BookReading;
use App\Models\BookReadingStats;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class BookReadingController extends Controller
{
    function readingTrack(Request $request){
        $user_id = Auth::guard('api')->id();
        $reading = BookReading::firstOrNew(['user_id'=>$user_id,'book_id'=>$request->book_id]);
        $reading->book_current_page = $request->current_page;
        $reading->save();

        $prv_reading_stats = BookReadingStats::where('reading_id',$reading->reading_id)->where('book_page_number',$request->current_page-1)->first();
        if($prv_reading_stats) {
            $prv_reading_stats->end_time = Carbon::now()->format('H:i:s');
            $prv_reading_stats->save();
        }

        $reading_stats = BookReadingStats::firstOrNew(['reading_id'=>$reading->reading_id,'book_page_number'=>$request->current_page]);
        $reading_stats->start_time = Carbon::now()->format('H:i:s');
        $reading_stats->save();

        return response()->json(['message'=>'success']);
    }

    function openReadingBook(Request $request){
        $user_id = Auth::guard('api')->id();
        $reading = BookReading::firstOrNew(['user_id'=>$user_id,'book_id'=>$request->book_id]);
        if(!isset($reading->reading_id)){
            $reading->book_total_pages = $request->total_pages;
            $reading->book_current_page = $request->current_page;
            $reading->save();
            $reading_stats =new BookReadingStats();
            $reading_stats->reading_id = $reading->reading_id;
            $reading_stats->book_page_number = $request->current_page;
            $reading_stats->start_time = Carbon::now()->format('H:i:s');
            $reading_stats->save();
        }
        return response()->json(['message'=>'success']);

    }
}
