<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;
use Response;
use Illuminate\Support\Facades\Auth;
use App\Home;

class HomeController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    return view('pdf-viewer');
  }

  public function ajaxSaveExpressions(Request $request)
  {
    $data = array();
    $location = '';
    $reader_user_id = Auth::id();
    $data = $request->all();
    $img = $request->pic_data;
    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $img_name = time().'_'.Auth::id().'_'.$request->facial_expression.'_picture.jpeg';
    
    if(!Storage::exists('imgs/student_'.Auth::id()))
    {
        Storage::makeDirectory('imgs/student_'.Auth::id(), 0775, true);
        Storage::put('imgs/student_'.Auth::id().'/'.$img_name, $data);
    }
    else
    {
      Storage::put('imgs/student_'.Auth::id().'/'.$img_name, $data);

    }

    if (Storage::exists('imgs/student_'.Auth::id().'/'.$img_name))
    {
      $reader_data = Home::UpdateorCreate(
        ['reader_user_id'=>$reader_user_id],
        [
        'reader_user_id' => $reader_user_id,
        'reader_page_no' => $request['page_number'],
        'reader_book_id' => 1,
        'reader_book_title' => 'Test',
        'reader_created_at' => date('Y-m-d'),
      ]

      );
      echo $reader_data;


    }

  }


}
