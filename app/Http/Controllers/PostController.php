<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function getComments($id) {
        $comments = DB::table('comments')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->where('comments.post_id', $id)
            ->orderBy('comments.created_at')
            ->get(array(
                'comments.id',
                'users.name as user',
                'comments.text'
            ));
        return $comments;
    }
}
