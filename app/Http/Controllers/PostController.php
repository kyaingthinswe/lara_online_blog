<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Photo;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::search()->latest('id')->paginate(5);

//        $posts = Post::when(isset(request()->search),function ($query){
//            $search = request()->search;
//            $query->where('title',"LIKE","%$search%")->orWhere('description',"LIKE","%$search%");
//
//        })->latest('id')->paginate(5);
//        return $posts;
        return view('post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
//       return $request;
        $request->validate([
            'title' => 'required|unique:posts,title|min:3',
            'category' => 'required|exists:categories,id|integer',
            'description' => 'required|min:20',
            "photos" => "required",
            "photos.*" => "file|mimes:jpeg,png|max:3000",
            'tags' => 'required',
            'tags.*'=>'integer|exists:tags,id'
        ]);
//        return $request->photo;

        $post = new Post();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->description = $request->description;
        $post->excerpt = Str::words($request->description,20);
        $post->user_id = Auth::id();
        $post->category_id = $request->category;
        $post->isPublish = true;
        $post->save();

        //save record to pivot tb
        $post->tags()->attach($request->tags);

        if (!Storage::exists('public/thumbnail')){
            Storage::makeDirectory('public/thumbnail');
        }

        //Storage->photo ကို အရင်သိမ်းပြီးမှ db ထဲကို သိမ်းမယ်
        if ($request->hasFile('photos')){
            foreach ($request->file('photos') as $photo){

                //store file in storage
                //$dir = 'public/photo/';
                $newName= uniqid()."_photo.".$photo->extension();
                $photo->storeAs("public/photo/",$newName);

                $thumb = "storage/thumbnail/";
                $img= Image::make($photo);
                $img->fit(200,200);
                $img->save($thumb.$newName);

                //save into database
                $photo = new Photo();
                $photo->name = $newName;
                $photo->user_id = Auth::id();
                $photo->post_id = $post->id;
                $photo->save();

            }
        }

        return redirect()->route('post.index')->with('status','Post is Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
//        return $post->tags;
//        return $post;
        return view('post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
//        return $post;
        return view('post.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
//        return $request;
        $request->validate([
            'title' => "required|unique:posts,title,$post->id|min:3",
            'category' => 'required|exists:categories,id|integer',
            'description' => 'required|min:20',

        ]);
        //tags ကို အရင်ဖျတ် ပြီးရင် ပြန်ထည့်
        $post->tags()->detach();
        $post->tags()->attach($request->tags);

        $post->title = $request->title;
        $post->slug = $request->title;
        $post->description = $request->description;
        $post->excerpt = Str::words($request->description,20);
        $post->category_id = $request->category;
        $post->update();

        return redirect()->route('post.index')->with('status','Post is Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //delete file
        foreach ($post->photos as $photo){
            Storage::delete('public/photo/'.$photo->name);
            Storage::delete('public/thumbnail/'.$photo->name);
        }

        // delete in db
        $post->photos()->delete();

        $post->delete();

        return redirect()->back()->with('status','Post is Deleted');
    }
}
