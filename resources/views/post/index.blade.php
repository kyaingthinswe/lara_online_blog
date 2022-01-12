@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Post List</h4>

                        @isset(request()->search)
                            <a href="{{ route('post.index') }}" class="btn btn-outline-primary mr-3">
                                <i class="feather-list"></i>
                                All Post
                            </a>
                            <span>Search By : " {{ request()->search }} "</span>
                        @endisset

                        <form class="w-25" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="{{request('search')}}" placeholder="Search Something" required>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">


                        <table class="table table-hover ">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="w-25">Title</th>
                                <th>Photo</th>
                                <th>Is Publish</th>
                                <th>Category</th>
                                <th>Owner</th>
                                <th>Control</th>
                                <th>Created_at</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($posts as $p)
                                <tr>
                                    <td>{{$p->id}}</td>
                                    <td class="small ">{{\Illuminate\Support\Str::words($p->title,10)}}</td>
                                    <td>
                                        @forelse($p->photos()->latest()->limit(3)->get() as $photo)
                                            <a class="venobox" data-gall="photo{{$p->id}}" href="{{asset('storage/photo/'.$photo->name)}}">
                                                <img src="{{asset('storage/thumbnail/'.$photo->name)}}" class="rounded-circle border border-2 border-primary image_ui" height="40" alt="image alt"/>
                                            </a>
                                        @empty
                                            <p class="text-muted">no photo</p>
                                        @endforelse
                                    </td>
                                    <td>

                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"  id="flexSwitchCheckChecked" {{$p->isPublish ? 'checked' : ''}}>
                                            <label class="form-check-label" for="flexSwitchCheckChecked">
                                                {{$p->isPublish ? 'Publish' : 'Unpublish'}}
                                            </label>
                                        </div>



                                    </td>
                                    <td>{{$p->category->title}}</td>
                                    <td>{{$p->user->name ?? "Unknown User"}} </td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-outline-primary " href="{{route('post.show',$p->id)}}">
                                                <i class="fas fa-info-circle fa-fw"></i>
                                            </a>
                                            <a class="btn btn-sm btn-outline-primary " href="{{route('post.edit',$p->id)}}">
                                                <i class="fas fa-pencil-alt fa-fw"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-primary" form="PostDeleteForm{{$p->id}}">
                                                <i class="fas fa-trash fa-fw"></i>
                                            </button>
                                        </div>
                                        <form action="{{route('post.destroy',$p->id)}}" id="PostDeleteForm{{$p->id}}" class="d-inline-block" method="post">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </td>
                                    <td>
                                        <p class="mb-0">
                                            <i class="fas fa-calendar fa-fw"></i>
                                            {{$p->created_at->format('Y-d-m')}}
                                        </p>

                                        <p class="mb-0">
                                            <i class="fas fa-clock fa-fw"></i>
                                            {{$p->created_at->format('H:m a')}}
                                        </p>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="6">THERE IS NO POST !</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between">
                            {{$posts->appends(request()->all())->links()}}
                            <p class="h4 font-weight-bold mb-0">Total: {{$posts->total()}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
