@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12  ">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Edit Post</h4>
                        <a href="{{route('post.index')}}" class="btn btn-primary"> Post List</a>
                    </div>
                    <div class="card-body">
                        <form action="{{route('post.update',$post->id)}}" id="updateForm" method="post" >
                            @csrf
                            @method('put')
                        </form>

                        <div class="mb-3">
                                <label for="">Post Title</label>
                                <input type="text" name="title" form="updateForm" value="{{old('title',$post->title)}}" class="form-control @error('title') is-invalid @enderror">
                                @error('title')
                                <small class="text-danger font-weight-bold">{{$message}}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="">Select Category</label>
                                <select name="category" form="updateForm" class="form-select @error('category') is-invalid @enderror" >
                                    @foreach(\App\Models\Category::all() as $c)
                                        <option value="{{$c->id}}" {{$c->id == old('category',$post->category_id)? 'selected':''}}>{{$c->title}}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <small class="text-danger font-weight-bold">{{$message}}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="">Photo</label>
                                <div class="overflow-scroll d-flex border rounded p-3">

                                    <form action="{{route('photo.store')}}" class="d-none" method="post" id="photoUploadForm" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{$post->id}}">
                                        <label >Photo</label>
                                        <input type="file" name="photo[]" value="{{old('photo')}}"  id="photoUploadInput" class="form-control @error('photo') is-invalid @enderror" multiple>
                                        @error('photo')
                                        <small class="text-danger font-weight-bold">{{$message}}</small>
                                        @enderror
                                        <button class="btn btn-primary">Upload</button>
                                    </form>
                                    <div class="uploader_ui d-flex justify-content-center align-items-center px-3 border border-1 border-dark"  id="photoUploadIcon">
                                        <i class="fas fa-plus fa-2x"></i>
                                    </div>
                                    @forelse($post->photos as $photo)
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
                                        <p class="text-mute">no photo</p>
                                    @endforelse
                                </div>

                            </div>

                            <div class="mb-3">
                                <label for="">Post Description</label>
                                <textarea name="description" form="updateForm" cols="30" rows="5" class="form-control @error('description') is-invalid @enderror">{{old('description',$post->description)}}</textarea>
                                @error('description')
                                <small class="text-danger font-weight-bold">{{$message}}</small>
                                @enderror
                            </div>

                            <div class="">
                                <button form="updateForm" class="btn btn-primary">Update Post</button>
                            </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let photoUploadForm = document.getElementById('photoUploadForm');
        let photoUploadInput = document.getElementById('photoUploadInput');
        let photoUploadIcon = document.getElementById('photoUploadIcon');

        photoUploadIcon.addEventListener('click',function () {
            photoUploadInput.click();
        })
        photoUploadInput.addEventListener('change',function () {
            photoUploadForm.submit();
        })
    </script>


@endsection

