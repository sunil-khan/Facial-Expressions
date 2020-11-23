<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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

    public function iFrameBookReading(Request $request){

        $validator = Validator::make($request->all(),[
            'pdf_url' => 'required|max:191',
            'user_id' => 'required',
        ]);

        if ($validator->fails())
        {
            $message = $validator->errors()->first();
            return response()->json($message);
        }

        $pdf_file_name = trim(basename($request->pdf_url));

        $book = Book::firstOrNew(['book_file'=>$pdf_file_name]);
        if(!$book->exists) {

            if (!File::exists(public_path('uploads/books'))) {
                File::makeDirectory(public_path('uploads/books'), 0777, true, true);
            }

            copy($request->pdf_url,public_path("uploads/books/$pdf_file_name"));

            if(isset($request->pdf_title) && !empty($request->pdf_title)) {
                $pdf_title = $request->pdf_title;
            }else{
                $without_extension = pathinfo($pdf_file_name, PATHINFO_FILENAME);
                $pdf_title = str_replace(['-','_'],' ',$without_extension);
            }

            $book->book_title = $pdf_title;
            $book->book_file = $pdf_file_name;
            $book->book_slug = $this->create_slug($book->book_title);
            $book->save();
        }


        if (!File::exists(public_path('csvs'))) {
            File::makeDirectory(public_path('csvs'), 0777, true, true);
        }
        $fileName = "expressions_".$request->user_id."_{$book->book_id}.csv";
        $file = fopen(public_path("csvs/$fileName"),"w");
        $columns = array('Expression', 'Value');
        fputcsv($file, $columns);
        fclose($file);
        $user_id = $request->user_id;

        $book->load(['UserBookReading'=>function($q)use($user_id){
            $q->where('user_id',$user_id);
        }]);




        return view('books.iframe_show',compact('book','user_id'));

    }



    function create_slug($slug_name)
    {
        // Normalize the title
        $slug = str_slug($slug_name);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->get_related_slugs($slug_name);

        // If we haven't used it before then we are all good.
        if (!$allSlugs->contains('book_slug', $slug)) {
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('book_slug', $newSlug)) {
                return $newSlug;
            }
        }
    }

    function get_related_slugs($slug_name)
    {
        $query =Book::select('book_slug')->where('book_slug', 'like', $slug_name . '%');
        return $query->get();
    }



}
