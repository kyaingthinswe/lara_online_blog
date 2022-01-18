@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-8  ">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Create Post</h4>
                        <a href="{{route('post.index')}}" class="btn btn-primary"> Post List</a>
                    </div>
                    <div class="card-body">
                        <form action="{{route('post.store')}}" method="post" enctype="multipart/form-data" >
                            @csrf
                                <div class="mb-3">
                                    <label for="">Post Title</label>
                                    <input type="text" name="title" value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror">
                                    @error('title')
                                    <small class="text-danger font-weight-bold">{{$message}}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="">Select Category</label>
                                    <select name="category" class="form-select @error('category') is-invalid @enderror" >
                                        @foreach(\App\Models\Category::all() as $c)
                                        <option value="{{$c->id}}" {{$c->id == old('category')? 'selected':''}}>{{$c->title}}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                    <small class="text-danger font-weight-bold">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="">Select Tag</label>
                                    <br>
                                    @foreach(\App\Models\Tag::all() as $tag)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="tags[]" type="checkbox" value="{{$tag->id}}" id="tag{{$tag->id}}" {{in_array($tag->id,old('tags',[]))?"checked":""}}>
                                        <label class="form-check-label" for="tag{{$tag->id}}">
                                            {{$tag->title}}
                                        </label>
                                    </div>

                                    @endforeach
                                    <br>
                                    @error('tags')
                                    <small class="text-danger font-weight-bold">{{$message}}</small>
                                    @enderror
                                    @error('tags.*')
                                    <small class="text-danger font-weight-bold">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label >Photo</label>
                                    <input type="file" name="photos[]" value="{{old('photos')}}" class="form-control @error('photos') is-invalid @enderror" multiple>
                                    @error('photos')
                                    <small class="text-danger font-weight-bold">{{$message}}</small>
                                    @enderror
                                    @error('photos.*')
                                    <small class="text-danger font-weight-bold">{{$message}}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="">Post Description</label>
                                    <textarea name="description"  cols="30" rows="5" class="form-control @error('description') is-invalid @enderror">{{old('description')}}</textarea>
                                    @error('description')
                                    <small class="text-danger font-weight-bold">{{$message}}</small>
                                    @enderror
                                </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" required>
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Confirm</label>
                                </div>
                                <button class="btn btn-lg btn-primary">Create Post</button>

                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
