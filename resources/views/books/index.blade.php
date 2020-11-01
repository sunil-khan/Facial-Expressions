@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Books</div>
                    <div class="card-body">
                        <div class="row">
                        @forelse($books as $book)
                        <div class="col-md-3">
                            <div class="best-seller-pro">
                                <figure>
                                    <img src="{{ asset("uploads/books/thumbs/$book->book_thumb") }}" alt="">
                                </figure>
                                <div class="kode-text">
                                    <h3>{{ $book->book_title }}</h3>
                                </div>
                                <div class="kode-caption">
                                    <h3>{{ $book->book_title }}</h3>
                                    <div class="rating">
                                        <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                                    </div>
                                    <p>{{ $book->book_author_name }}</p>
                                    <a href="{{ route('books.show',$book->book_slug) }}" class="read-book">Read Book</a>
                                </div>
                            </div>
                        </div>
                            @empty

                            <div class="col-md-12">
                               There is no book available.
                            </div>

                            @endforelse



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('post-styles')
<style>


    /*
    ==========================================
                BEST SELLERS
    ==========================================
    */


    .best-seller-pro{
        cursor: pointer;
        float:left;
        width:100%;
        padding:30px;
        background-color:#fff;
        text-align:center;
        position:relative;
        overflow:hidden;
        margin-bottom:30px;
        border:solid 1px #f0f0f0;
    }
    .best-seller-pro figure{
        float:left;
        width:100%;
        margin-bottom:20px;
    }
    .best-seller-pro figure img{
        float:left;
        width:100%;
    }
    .best-seller-pro h3{
        font-size:18px;
        font-weight:normal;
        margin:0px;
    }
    .best-seller-pro h3 a{
        color:#333;
    }
    .best-seller-pro .kode-text{
        float:left;
        width:100%;
    }
    .best-seller-pro .kode-caption{
        position:absolute;
        left:0px;
        top:50%;
        width:100%;
        padding:30px;
        text-align:center;
        opacity:0;
        margin-top:30px;
    }
    .best-seller-pro:before{
        content:"";
        position:absolute;
        left:0px;
        top:0px;
        height:100%;
        width:100%;
        opacity:0;
        background: #11c8de;
        color: #fff;
        text-shadow: none;
    }
    .best-seller-pro:hover:before{
        opacity:1
    }
    .best-seller-pro:hover .kode-caption{
        opacity:1;
        margin-top:-140px;
    }
    .best-seller-pro .kode-caption h3{
        font-weight:bold;
        font-size:22px;
        color:#fff;
        margin:0px 0px 10px 0px;
    }
    .best-seller-pro .kode-caption h3 a{
        color:#fff;
        text-decoration:none;
    }
    .best-seller-pro .kode-caption p{
        color:#fff;
    }
    .best-seller-pro .kode-caption .rating{
        margin-bottom:10px;
    }

    .best-seller-pro .kode-caption a.read-book{
        display:inline-block;
        font-size:14px;
        color:#fff;
        text-transform:uppercase;
        font-weight:bold;
        padding:10px 20px;
        border:solid 2px #fff;
        text-decoration:none;
        line-height:normal;
    }
    .best-seller-pro .kode-caption a.read-book:hover{
        color:#000;
        background-color:#fff;
    }

    /*
==========================================
			RATING START
==========================================
*/
    .rating {
        unicode-bidi: bidi-override;
        direction: rtl;
    }
    .rating > span {
        display: inline-block;
        position: relative;
        color:#fff;
        font-size:20px;
    }
    .rating > span:hover:before,
    .rating > span:hover ~ span:before {
        content: "\2605";
        position: absolute;
    }

</style>
@endpush