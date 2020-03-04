@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="text-center mb-3">
                <a href="{{ route('index', 1) }}" class="btn btn-outline-dark mr-2">Room 1</a>
                <a href="{{ route('index', 2) }}" class="btn btn-outline-dark ml-2">Room 2</a>
            </div>
        </div>
    </div>
    <chat :room="{{ $room }}"></chat>
</div>
@endsection
