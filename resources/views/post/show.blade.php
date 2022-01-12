@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header ">
                        <h4>{{$post->title}}</h4>
                        <a   class="budge rounded-pill bg-secondary px-2 text-decoration-none text-light ">{{$post->category->title}}</a>
                    </div>
                    <div class="card-body">
                        <p>{{$post->description}}</p>
                        <div class="row">
                            <div class="d-flex justify-content-between align-items-center">
                                <p>
                                    <i class="fas fa-user"></i>
                                    {{$post->user->name ?? 'Unknown'}}
                                </p>
                                <p>
                                    {{$post->created_at->diffForHumans()}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
