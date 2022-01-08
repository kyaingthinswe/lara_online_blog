@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12  ">
                <div class="card">
                    <div class="card-header">
                        <h4>Update Category</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('category.update',$category->id)}}" method="post" >
                            @csrf
                            @method('put')
                            <div class="row align-items-end">
                                <div class="col-6 col-lg-3">
                                    <label for="">Category Title</label>
                                    <input type="text" name="title" value="{{old('title',$category->title)}}" class="form-control @error('title') is-invalid @enderror">
                                </div>
                                <div class="col-6 col-lg-3">
                                    <button class="btn btn-primary">Update Category</button>
                                </div>
                            </div>
                            @error('title')
                            <small class="text-danger font-weight-bold">{{$message}}</small>
                            @enderror
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
