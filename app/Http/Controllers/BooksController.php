<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class BooksController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::where('book_status',1)->get();
        return view('books.index',compact('books'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $book = Book::with(['UserBookReading'=>function($q){
            $q->where('user_id',Auth::id());
        }])->where('book_slug',$slug)->first();
        if(!$book){
            Session::flash('error_message', 'No Record found.');
            return redirect(route('books.index'));
        }

        if (!File::exists(public_path('csvs'))) {
            File::makeDirectory(public_path('csvs'), 0777, true, true);
        }
        $fileName = "expressions_".Auth::id()."_{$book->book_id}.csv";
        $file = fopen(public_path("csvs/$fileName"),"w");
        $columns = array('Expression', 'Value');
        fputcsv($file, $columns);
        fclose($file);

        return view('books.show',compact('book'));
    }
}
