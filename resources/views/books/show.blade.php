@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Title: {{ $book->book_title }}, Author Name: {{ $book->book_author_name }}</div>
                    <div class="card-body">
                        <web-viewer-component :book="{{ $book }}"></web-viewer-component>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection