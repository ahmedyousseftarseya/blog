<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::all();
        if($posts->isEmpty()) {
            return responseJson(404, __('lang.posts_not_found'));
        }
        return responseJson(200, null, PostResource::collection($posts));
    }

    public function show($id)
    {
        $post = Post::find($id);
        if(!$post) {
            return responseJson(204, __('lang.post_not_found'));
        }
        return responseJson(200, null, PostResource::make($post));
    }

    public function store(PostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth('api')->user()->id;
        $post = Post::create($data);
        return responseJson(200, __('lang.post_created'), PostResource::make($post));
    }

    public function update(PostRequest $request, $id)
    {
        $data = $request->validated();
        $post = Post::find($id);
        if(!$post) {
            return responseJson(404, __('lang.post_not_found'));
        }
        $post->update($data);
        return responseJson(200, __('lang.post_updated'), PostResource::make($post));
    }

    public function destroy(Post $post)
    {
        if(!$post) {
            return responseJson(404, __('lang.post_not_found'));
        }
        $post->delete();
        return responseJson(200, __('lang.post_deleted'));
    }


}
