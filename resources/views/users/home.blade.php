@extends('layouts.app')

@section('content')
<script src="{{ asset('js/angular-sanitize.js') }}"></script>
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

                <div class="panel-body" ng-app="homeApp" ng-controller="homeCtrl">

                    <form id="form-post"class="form-horizontal" role="form" method="POST" action="{{ route('post') }}">

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-3 control-label">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" ng-model="title" value="{{ old('title') }}" required autofocus>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-8 col-md-offset-2">
                            <textarea id="text" class="form-control" name="text" ng-model="text" form="form-post"></textarea>
                            <br>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-8">
                                <button type="button" class="btn btn-primary" ng-click="send()" >
                                    &nbsp;&nbsp;&nbsp;Post&nbsp;&nbsp;&nbsp;
                                </button>
                            </div>
                        </div>

                        <hr>
                    </form>

                    <div class="row" ng-repeat="post in posts">
                        <div id="@{{post.id}}" class="col-md-12">
                            <h2 ng-bind-html="post.title"></h2>
                            <p align="justify" ng-bind-html="post.text"></p>
                            <div ng-if="!load[post.id]">
                                <a href="#@{{post.id}}" ng-click="loadComments(post.id)">Load Comments</a>
                            </div>
                            <div ng-if="load[post.id]">
                                <div class="row" ng-repeat="comment in comments[post.id]">
                                    <div class="col-md-8 col-md-offset-2">
                                        <p align="justify" ng-bind-html="comment.text"></p>
                                        <p align="center" ng-bind-html="comment.user"></p>
                                        <hr>
                                    </div>
                                </div>
                                <a href="#@{{post.id}}" ng-click="closeComments(post.id)">Close Comments</a>
                                <hr>
                            </div>
                        </div>
                    </div>

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

<script type="text/javascript">
    var app = angular.module('homeApp', ['ngSanitize']);

    app.controller('homeCtrl', function($scope, $http) {
        $scope.text = "What's in your mind?";

        var pst = "{{ $user->posts }}";
        pst = pst.replace(/\n/g,"\\n");
        $scope.posts = JSON.parse(pst.replace(/&quot;/g, "\""));
        $scope.comments = [[]];
        $scope.load = [];
        for (var i = 0; i < $scope.posts.length; i++) {
            var v = $scope.posts[i];
            $scope.load[v.id] = false;
        }

        $scope.send = function(){
            var data = $.param({
                title: $scope.title,
                text: $scope.text,
                _token: "{{ csrf_token() }}"
            });

            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

            $http.post('{{ route("post") }}', data, config)
            .then(function (data, status, headers, config) {
                var out = '';
                $scope.title = '';
                $scope.text = '';
                $scope.posts.unshift(data['data']) ;
            },
            function (data, status, header, config) {
                alert("Data: " + data +
                    "\nstatus: " + status +
                    "\nheaders: " + header +
                    "\nconfig: " + config);
            });
        }

        $scope.loadComments = function(id) {
            $http.get('{{ URL::to("posts/getComments") }}/'+id)
            .then(function (responseData, status, headers, config) {
                $scope.comments[id] = [];
                var data = responseData['data'];
                for (var dt in data) {
                    $scope.comments[id].unshift(data[dt]);
                }
                $scope.load[id] = true;
            },
            function (data, status, header, config) {
                alert("Data: " + data +
                    "\nstatus: " + status +
                    "\nheaders: " + header +
                    "\nconfig: " + config);
            });
        }

        $scope.closeComments = function(id) {
            $scope.load[id] = false;
        }
    });
</script>
@endsection
