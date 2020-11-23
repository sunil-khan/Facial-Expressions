<?php

namespace App\Http\Controllers\Api;

use App\Models\BookReading;
use App\Models\BookReadingExpression;
use App\Models\BookReadingStats;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Auth;
use Illuminate\Support\Str;
use Storage;
class BookReadingController extends Controller
{
    function readingTrack(Request $request){
        $user_id = $request->user_id;
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
        else {

            $reading->book_current_page = $request->current_page;
            $reading->save();

            $prv_reading_stats = BookReadingStats::where('reading_id', $reading->reading_id)->where('book_page_number', $request->current_page - 1)->first();
            if ($prv_reading_stats) {
                $prv_reading_stats->end_time = Carbon::now()->format('H:i:s');
                $prv_reading_stats->save();
            }

            $reading_stats = BookReadingStats::firstOrNew(['reading_id' => $reading->reading_id, 'book_page_number' => $request->current_page]);
            $reading_stats->start_time = Carbon::now()->format('H:i:s');
            $reading_stats->save();
        }

        return response()->json(['message'=>'success']);
    }

    function expressionTrack(Request $request){
        $user_id = $request->user_id;
        $img = $request->pic_data;
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $img_name = time().'_'.$user_id.'_'.$request->expression_type.'_picture.jpeg';

        if(!Storage::exists('imgs/student_'.$user_id))
        {
            Storage::makeDirectory('imgs/student_'.$user_id, 0775, true);
            Storage::put('imgs/student_'.$user_id.'/'.$img_name, $data);
        }
        else
        {
            Storage::put('imgs/student_'.$user_id.'/'.$img_name, $data);
        }

        $expresssion = new BookReadingExpression;
        $expresssion->user_id = $user_id;
        $expresssion->book_id = $request->book_id;
        $expresssion->book_current_page = $request->current_page;
        $expresssion->expression_type = $request->expression_type;
        $expresssion->expression_image_name = $img_name;
        $expresssion->save();

        return response()->json(['message'=>'success']);
    }

    function csvWriteExpression(Request $request){
        $user_id = $request->user_id;
        $book_id = $request->book_id;
        $fileName = "expressions_{$user_id}_{$book_id}.csv";
        if(isset($request->expressions) && !empty($request->expressions)){

            if (!File::exists(public_path('csvs'))) {
                File::makeDirectory(public_path('csvs'), 0777, true, true);
            }
            $file = fopen(public_path("csvs/$fileName"),"w");
            $columns = array('Expression', 'Value');
            fputcsv($file, $columns);
            foreach ($request->expressions as $expression){
                $row = array(Str::ucfirst($expression['name']),$expression['y']*100);
                fputcsv($file, $row);
            }
            fclose($file);
        }

        return response()->json(['message'=>'success']);

    }

}
