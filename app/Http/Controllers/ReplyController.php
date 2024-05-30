<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;
use App\Http\Requests\ReplyRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\ReplyResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Reply;

class ReplyController extends Controller
{
    public function index($commentId)
    {
        $comment = Comment::find($commentId);
        if(!$comment) {
            return responseJson(204, __('lang.Comment_not_found'));
        }

        $replies = $comment->replies()->get();

        if($replies->isEmpty()) {
            return responseJson(204, __('lang.replies_not_found'));
        }

        return responseJson(200, null, ReplyResource::collection($replies));
    }


    public function store(ReplyRequest $request, $commentId)
    {
        $comment = Comment::find($commentId);
        if(!$comment) {
            return responseJson(404, __('lang.Comment_not_found'));
        }
        $data = $request->validated();
        $data['user_id'] = auth('api')->user()->id;
        $data['comment_id'] = $commentId;
        $reply = Reply::create($data);
        return responseJson(200, __('lang.Reply_created'), ReplyResource::make($reply));
    }

    public function show($commentId, $id)
    {
        $comment = Comment::find($commentId);
        if(!$comment) {
            return responseJson(404, __('lang.Comment_not_found'));
        }

        $reply = Reply::where('comment_id', $commentId)->find($id);

        if(!$reply) {
            return responseJson(204, __('lang.reply_not_found'));
        }
        return responseJson(200, null, ReplyResource::make($reply));
    }


    public function update(ReplyRequest $request, $commentId, $id)
    {
        $comment = Comment::find($commentId);
        if(!$comment) {
            return responseJson(404, __('lang.Comment_not_found'));
        }

        $reply = Reply::where('comment_id', $commentId)->find($id);

        if(!$reply) {
            return responseJson(404, __('lang.reply_not_found'));
        }

        $data = $request->validated();

        $reply->update($data);
        return responseJson(200, __('lang.reply_updated'), ReplyResource::make($reply));
    }

    public function destroy($commentId, $id)
    {
        $comment = Comment::find($commentId);
        if(!$comment) {
            return responseJson(404, __('lang.comment_not_found'));
        }

        $reply = Reply::where('comment_id', $commentId)->find($id);
        if(!$reply) {
            return responseJson(404, __('lang.reply_not_found'));
        }

        $reply->delete();

        return responseJson(200, __('lang.comment_deleted'));
    }


}
