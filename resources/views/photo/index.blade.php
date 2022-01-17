@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Photo</h4>
                    </div>
                    <div class="card-body">

                        @if(session('status'))
                            <p class="alert alert-success">{{session('status')}}</p>
                        @endif

                            @forelse(auth()->user()->photos as $photo)
                                <div  class="d-inline-block position-relative ">
                                    <form action="{{route('photo.destroy',$photo->id)}}" class="position-absolute start-0 bottom-0" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <img src="{{asset('storage/thumbnail/'.$photo->name)}}" style=" height: 100px;" alt="">

                                </div>
                            @empty
                                <p class="text-muted">no photo</p>
                            @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
