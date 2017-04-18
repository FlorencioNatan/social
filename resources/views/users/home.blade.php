@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $user->name }}</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4"><p class="text-right"><strong> Name: </strong></p></div>
                        <div class="col-md-6"><p>{{ $user->name }}</p></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><p class="text-right"><strong> E-mail: </strong></p></div>
                        <div class="col-md-6"><p>{{ $user->email }}</p></div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Posts</div>

                <div class="panel-body">
                    <?php foreach ($user->posts as $key => $post): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>{{ $post->title }}</h2>
                                <p align="justify">{{ $post->text }}</p>
                            </div>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Friends</div>

                <div class="panel-body">
                    <?php foreach ($user->getFriends() as $key => $friend): ?>
                        <div class="row">
                            <div class="col-md-4"><p class="text-right"><strong> Name: </strong></p></div>
                            <div class="col-md-6"><p>{{ $friend->name }}</p></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><p class="text-right"><strong> E-mail: </strong></p></div>
                            <div class="col-md-6"><p>{{ $friend->email }}</p></div>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
