<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\BookReading;
use App\Models\BookReadingExpression;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
   function index(){
       //return $this->GetExpressionGraphData(1);
       $books = Book::where('book_status',1)->get();
       $book_reading = BookReading::with(['BookStats'=>function($q){
           $q->where('book_page_number','!=',1);
       }])->where('book_id',32)->whereIn('user_id',[2,6,8,5,12])->orderBy('user_id')->get();
        $expressions = $this->getExpressionTable($book_reading);
       return view('admin.dashboard.dashboard',compact('books','expressions'));
   }

    public function GetExpressionGraphData($book_id=null,$page_no=null,$start_date=null,$end_date=null)
    {
        //$default_expressions = ['angry','disgusted','fearful','happy','neutral','sad','surprised'];
        $expression_query = BookReadingExpression::select(DB::raw('CONCAT(UCASE(LEFT(expression_type, 1)), SUBSTRING(expression_type, 2)) as name'), DB::raw('count(expression_id) as y'))
        ->where('book_id',$book_id)->where('book_current_page','!=',1)->groupBy('expression_type');

        if (!empty($page_no)) {
            $expression_query->where('book_current_page',$page_no);
        }

        if ( !empty($start_date) && !empty($end_date)) {
            $start_date = Carbon::parse($start_date)->format('Y-m-d');
            $end_date = Carbon::parse($end_date)->format('Y-m-d');
            $expression_query->whereBetween(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), [$start_date,$end_date]);
        }
        $expressions = $expression_query->get();

        return $expressions;
    }

    function getFilterGraphAjax(Request $request){
        $book_id = isset($request->book_id)?$request->book_id:null;
        $page_no = isset($request->page_no)?$request->page_no:null;
        $start_date = isset($request->start_date)?$request->start_date:null;
        $end_date = isset($request->end_date)?$request->end_date:null;

        $response = array();
        $response['data_bg'] = $this->GetExpressionGraphData($book_id,$page_no,$start_date,$end_date);
        $response['status'] = true;
        return json_encode($response,JSON_NUMERIC_CHECK);
    }

    function getBookPagesAjax(Request $request){
      $book_reading = BookReading::select('book_total_pages')->where('book_id',$request->book_id)->first();
      $total_pages = isset($book_reading->book_total_pages)?$book_reading->book_total_pages:null;
      $pages = array();
      for ($i=1;$i<=$total_pages;$i++){
          $obj = new \stdClass;
          $obj->page_no = $i;
          array_push($pages,$obj);
      }

        $response = array();
        $response['data'] = $pages;
        $response['status'] = true;
        return json_encode($response);
    }

    function getExpressionTable($book_reading){
       $expression_table = array();

       // book reading - total pages and current page
       foreach ($book_reading as $br){

           // book stats per page time
           if(isset($br->BookStats) && !empty($br->BookStats)) {
               foreach ($br->BookStats as $book_stats) {
                   // expression for page wise

              $expression_created_at     = BookReadingExpression::select('created_at')
                       ->where('user_id',$br->user_id)
                       ->where('book_id',$br->book_id)
                       ->where('book_current_page',$book_stats->book_page_number)->orderBy('created_at','asc')->first();

              $expression_updated_at =   BookReadingExpression::select('updated_at')
                       ->where('user_id',$br->user_id)
                       ->where('book_id',$br->book_id)
                       ->where('book_current_page',$book_stats->book_page_number)->orderBy('updated_at','desc')->first();

                    if(!isset($expression_created_at->created_at) || !isset($expression_updated_at->updated_at))
                        continue;

                   $start_time = Carbon::parse($expression_created_at->created_at);
                   $end_time = Carbon::parse($expression_updated_at->updated_at);

                   $totalDuration = $start_time->diffInSeconds($end_time);
                   $per_paragraph_sec = !empty($totalDuration)?ceil($totalDuration/4):0;

                   $reading_paragraph_start_time = clone $start_time;
                   $reading_paragraph_end_time = clone $start_time->addSeconds($per_paragraph_sec);
                   $slot_no = 1;
                   for ($i = 1; $i <= 4; $i++) {


                           $expressions = $this->pageParagraphExpression($br, $book_stats,$reading_paragraph_start_time, $reading_paragraph_end_time);
                          foreach ($expressions as $expression){
                               $exp_row = new \stdClass;
                               $exp_row->user_id = $br->user_id;
                               $exp_row->page_no = $book_stats->book_page_number;
                               $exp_row->paragraph_no = $slot_no;
                               $exp_row->exp_type = $expression->expression_type;
                               $exp_row->exp_count = ceil($expression->total);

                               $exp_row->exp_utc = Carbon::parse($reading_paragraph_start_time)->format('H:i:s') .' - '.Carbon::parse($reading_paragraph_end_time)->format('H:i:s');
                               array_push($expression_table,$exp_row);
                           }
                       if($expressions->isNotEmpty())
                       $slot_no++;

                       $reading_paragraph_start_time = clone $reading_paragraph_end_time;
                       $reading_paragraph_end_time = clone $reading_paragraph_end_time->addSeconds($per_paragraph_sec);

                       }

               }
           }

       }

       return $expression_table;

    }

    public function pageParagraphExpression($book_reading,$book_stats,$reading_paragraph_start_time, $reading_paragraph_end_time)
    {


            $expressions= BookReadingExpression::
            select('expression_type', DB::raw('count(*) as total'))->
            where('user_id',$book_reading->user_id)->where('book_id',$book_reading->book_id)
                                    ->where('book_current_page',$book_stats->book_page_number)
                                   //->whereBetween('created_at', [$reading_paragraph_start_time,$reading_paragraph_end_time])
                                  ->where('created_at' , '>=',$reading_paragraph_start_time)
                                  ->where('updated_at' , '<=',$reading_paragraph_end_time)
                                  ->groupBy('expression_type')
                                  ->get();
            return $expressions;

    }


}
