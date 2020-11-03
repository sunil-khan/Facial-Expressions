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
       return view('admin.dashboard.dashboard',compact('books'));
   }

    public function GetExpressionGraphData($book_id=null,$page_no=null,$start_date=null,$end_date=null)
    {
        //$default_expressions = ['angry','disgusted','fearful','happy','neutral','sad','surprised'];
        $expression_query = BookReadingExpression::select(DB::raw('CONCAT(UCASE(LEFT(expression_type, 1)), SUBSTRING(expression_type, 2)) as name'), DB::raw('count(expression_id) as y'))
        ->where('book_id',$book_id)->groupBy('expression_type');

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

}
