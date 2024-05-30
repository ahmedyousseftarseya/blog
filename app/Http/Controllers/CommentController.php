<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    public function index($postId)
    {
        $post = Post::find($postId);
        if(!$post) {
            return responseJson(404, __('lang.post_not_found'));
        }
        $comments = Comment::where('post_id', $postId)->get();
        if($comments->isEmpty()) {
            return responseJson(204, __('lang.posts_not_found'));
        }
        return responseJson(200, null, CommentResource::collection($comments));
    }


    public function store(CommentRequest $request, $postId)
    {
        $post = Post::find($postId);
        if(!$post) {
            return responseJson(404, __('lang.post_not_found'));
        }
        $data = $request->validated();
        $data['user_id'] = auth('api')->user()->id;
        $data['post_id'] = $postId;
        $comment = Comment::create($data);
        return responseJson(201, __('lang.post_created'), CommentResource::make($comment));
    }


    public function show($postId, $id)
    {
        $post = Post::find($postId);
        if(!$post) {
            return responseJson(404, __('lang.post_not_found'));
        }

        $comment = Comment::where('post_id', $postId)->find($id);
        if(!$comment) {
            return responseJson(404, __('lang.comment_not_found'));
        }

        return responseJson(200, null, CommentResource::make($comment));
    }

    public function update(CommentRequest $request, $postId, $id)
    {
        $post = Post::find($postId);
        if(!$post) {
            return responseJson(404, __('lang.post_not_found'));
        }
        $comment = Comment::where('post_id', $postId)->find($id);

        if(!$comment) {
            return responseJson(404, __('lang.comment_not_found'));
        }
        $data = $request->validated();

        $comment->update($data);
        return responseJson(200, __('lang.comment_updated'), CommentResource::make($comment));
    }

    public function destroy($postId, $id)
    {
        $post = Post::find($postId);
        if(!$post) {
            return responseJson(404, __('lang.post_not_found'));
        }
        $comment = Comment::where('post_id', $postId)->find($id);
        if(!$comment) {
            return responseJson(404, __('lang.comment_not_found'));
        }
        $comment->delete();
        return responseJson(200, __('lang.comment_deleted'));
    }


}
