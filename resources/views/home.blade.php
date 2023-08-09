@extends('layouts.app')

@section('content')
    <div class="center-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="header">
                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <div class="name-box">
                                    <h1 class="text-center">Welcome, {{ Auth::user()->name }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .center-content {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .name-box {
            text-align: center;
        }
    </style>
@endsection
