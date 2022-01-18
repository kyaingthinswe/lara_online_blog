@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Category List</h4>
                        <a href="{{route('category.create')}}" class="btn btn-primary">Create Category</a>
                    </div>
                    <div class="card-body">

                        @if(session('status'))
                            <p class="alert alert-success">{{session('status')}}</p>
                            @endif

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Owner</th>
                                    <th>Control</th>
                                    <th>Created_at</th>
                                </tr>
                            </thead>
                            <tbody>
                          @forelse($categories as $c)
                                <tr>
                                    <td>{{$c->id}}</td>
                                    <td>{{$c->title}}</td>
                                    <td>{{$c->user->name}}</td>
                                    <td>

                                        <a class="btn btn-sm btn-outline-warning " href="{{route('category.edit',$c->id)}}">
                                            <i class="fas fa-pencil-alt fa-fw"></i>
                                        </a>
                                        <form action="{{route('category.destroy',$c->id)}}" class="d-inline-block" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash fa-fw"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <p class="mb-0">
                                            <i class="fas fa-calendar fa-fw"></i>
                                            {{$c->created_at->format('Y-d-m')}}
                                        </p>

                                        <p class="mb-0">
                                            <i class="fas fa-clock fa-fw"></i>
                                            {{$c->created_at->format('H:m a')}}
                                        </p>
                                    </td>
                                </tr>
                          @empty
                              <tr class="text-center">
                                  <td colspan="5">THERE IS NO CATEGORY !</td>
                              </tr>
                          @endforelse
                            </tbody>
                        </table>
                        <div class="">
                            <p>{{$categories->links()}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
