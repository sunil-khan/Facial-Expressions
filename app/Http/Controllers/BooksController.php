<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
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
        $book = Book::where('book_slug',$slug)->first();
        if(!$book){
            Session::flash('error_message', 'No Record found.');
            return redirect(route('books.index'));
        }
        return view('books.show',compact('book'));
    }
}
