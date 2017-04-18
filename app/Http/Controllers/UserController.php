<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('users.home')->with('user', $user);
    }

    /**
     * Store a newly created Post from current user in storage
     *
     * @return \Illuminate\Http\Response
     */
    public function userPost(Request $request)
    {
        $rules = array(
            'title' => 'required',
            'text' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return "Fail";
        }

        $post = new Post();
        $post->title = $request['title'];
        $post->text = $request['text'];
        $post->user_id = Auth::id();
        $post->created_at  = date("Y-m-d H:i:s");
        $post->updated_at  = date("Y-m-d H:i:s");
        $post->save();
        return $post;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
