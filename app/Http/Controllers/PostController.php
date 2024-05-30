<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    // get all posts as json
    public function index()
    {
        $posts = Post::all();
        return responseJson(200, null, $posts);
    }
}
