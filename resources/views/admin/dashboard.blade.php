@extends('admin.layouts.app')

@section('content')
    <div class="center-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1 class="text-center">Welcome, {{ Auth::user()->name }}</h1>
                </div>
            </div>
        </div>
    </div>
@endsection
