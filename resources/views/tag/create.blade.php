@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12  ">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Create Category</h4>
                        <a href="{{route('category.index')}}" class="btn btn-primary"> Category List</a>
                    </div>
                    <div class="card-body">
                        <form action="{{route('category.store')}}" method="post" >
                            @csrf
                           <div class="row align-items-end">
                               <div class="col-6 col-lg-3">
                                   <label for="">Category Title</label>
                                   <input type="text" name="title" value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror">
                               </div>
                               <div class="col-6 col-lg-3">
                                   <button class="btn btn-primary">Add Category</button>
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
