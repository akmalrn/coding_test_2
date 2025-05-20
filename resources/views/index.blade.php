@extends('layouts.app')
@section('content')
    <div class="row g-3 mx-4">
        <div class="col">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Authors</h5>
                    <p class="card-text fs-4">{{ $authorsTotal }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Books</h5>
                    <p class="card-text fs-4">{{ $booksTotal }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
