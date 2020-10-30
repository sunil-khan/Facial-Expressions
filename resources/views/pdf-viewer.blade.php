@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Books</div>
                    <div class="card-body">
                        <web-viewer-component :initial_doc="232"></web-viewer-component>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection