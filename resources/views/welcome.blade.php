<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Stack OverFlow</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/app.css">

        <!-- Javascript -->
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    </head>
    <body>
        <div class="position-ref full-height bg-warning ">
            @if (Route::has('login'))
            <div class="top-right links">
                @auth
                <a href="{{ url('/home') }}">Home</a>
                @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}">Register</a>
                @endif
                @endauth
                <a href="{{ route('post_question')}}">Post</a>
            </div>
            @endif

            <div class="container">
                @foreach($posts as $post)
                <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="cardheader pt-5 px-5">
                                    <h5 class="card-title font-weight-bold">Question</h5>
                                    <div class="row">
                                       
                                        <div class="col-2">
                                            <div class="container">
                                                <div>
                                                        <a class="postUp postUp{{$post->id}}" javascript(0) ><li class="fa fa-caret-up fa-2x block"></li></a>
                                                </div>
                                                <div>
                                                    <span class="block postCommentCount">{{count($post->thumbs->where('up_down', 'up'))-count($post->thumbs->where('up_down', 'down'))}}</span>
                                                </div>
                                                <div>
                                                        <a class="postDown postDown{{$post->id}}" javascript(0)  ><li class="fa fa-caret-down fa-2x block"></li></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-10">
                                            <textarea class="form-control textarea-resize-none text-left font-weight-bold " readonly  name="question">{{$post->question}}</textarea>
                                            @auth
                                                <form action="{{route('delete',$post->id)}}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="submit" class="float-right" value="Delete">
                                                </form>
                                                @if($post->user_id==auth()->user()->id)
                                                    <a class="float-right p-2"  href="{{route('show', $post->id)}}">edit</a>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>  
                                </div>
                                <div class="card-body px-5">
                                    <h5 class="card-title">Answers</h5>
                                    @foreach($post->comments as $commentshow)
                                        <div class="row align-middle">
                                            <div class="col-2">
                                                <div class="container align-middle text-center">
                                                    <div>
                                                        <a class="commentUp commentUp{{$commentshow->id}}" javascript(0) ><li class="fa fa-caret-up fa"></li></a>
                                                    </div>
                                                    <div>
                                                        <span class="block commentThumbsCount">{{count($commentshow->comments_thumbs->where('up_down', 'up'))-count($commentshow->comments_thumbs->where('up_down', 'down'))}}</span>
                                                    </div>
                                                    <div>
                                                    <a class="commentDown commentDown{{$commentshow->id}}" javascript(0) ><li class="fa fa-caret-down fa"></li></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-10 align-middle">
                                                @auth
                                                <form action="{{route('deleteComment',$commentshow->id)}}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="submit" class="float-right" value="Delete">
                                                </form>
                                                    @if($commentshow->user_id==auth()->user()->id)
                                                        <a class="float-right p-2 editComment"  javascript(0)>
                                                            Edit
                                                        </a>
                                                    @endif  
                                                @endauth
                                                <div id="{{$commentshow->id}}">{{$commentshow->discription}}</div>
                                            </div>
                                        </div>
                                        <br/>
                                    @endforeach
                                </div>
                            </div>

                            <div class="card my-3">
                                <div class="cardheader p-5">
                                    <h5 class="card-title">Post Answers</h5>
                                </div>

                                <form action="/comment" method="POST">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group row">
                                                <label for="question" class="col-form-label col-sm-3">Enter Answer</label>
                                                <div class="col-sm-9">
                                                    <input type="hidden" value="{{$post->id}}" name="post_id" >
                                                    <textarea type="text" name="discription" class="form-control form-control-lg" rows="5"></textarea>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-success">Post</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </body>
    <script>
        $(document).ready(function(){
            $('.editComment').on('click', clickEditableEvent);

            $('.commentUp').on('click',function(){
                var ref = $(this);

                $.ajax({
                    type:'POST',
                    url:'/comment/thumb',
                    data: {
                        comment_id: ref.attr('class').split(' ')[1].slice(9),
                        thumb: 'up',
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(data) {
                        ref.closest('.container').find('.commentThumbsCount').html(data);    
                    }
                });
            });
            
            $('.commentDown').on('click',function(){
                var ref = $(this);
                $.ajax({
                    type:'POST',
                    url:'/comment/thumb',
                    data: {
                        comment_id: ref.attr('class').split(' ')[1].slice(11),
                        thumb: 'down',
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(data) {
                        ref.closest('.container').find('.commentThumbsCount').html(data);    
                    }
                }); 
            });

            $('.postUp').on('click',function(){
                var ref = $(this);
                $.ajax({
                    type:'POST',
                    url:'/post/thumb',
                    data: {
                        post_id: $(this).attr('class').split(' ')[1].slice(6),
                        thumb: 'up',
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(data) {
                        ref.closest('.container').find('.postCommentCount').html(data);    
                    }
                });
            });

            $('.postDown').on('click',function(){
                var ref = $(this);
                $.ajax({
                    type:'POST',
                    url:'/post/thumb',
                    data: {
                        post_id: $(this).attr('class').split(' ')[1].slice(8),
                        thumb: 'down',
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(data) {
                        console.log(data);
                        ref.closest('.container').find('.postCommentCount').html(data);
                    }
                });
            });
        });
       
        function clickEditableEvent(e){
            var elem = $(this).next();
            var textarea = $('<textarea>').val($(elem).html());
            $(textarea).attr('id',$(elem).attr('id'));
            $(this).html('UPDATE');
            $(this).after(textarea);
            $(elem).remove();
            
            $(this).unbind();
            $(this).bind('click', function (){
                ajaxCall(this);
            });
        } 
        
        function ajaxCall(e){
           
            var commentElem = $(e).next();
            var commentId = $(commentElem).attr('id');
            var commentDiscription = $(commentElem).val();
            $.ajax({
                type:'POST',
                url:'/comment/update',
                data: {
                    comment_id: commentId,
                    comment_discription: commentDiscription,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(data) {
                    $(e).unbind();
                    $(e).bind('click',clickEditableEvent)
                    $(commentElem).remove();
                    var elem = $('<div>').attr('id',commentId).html(data['discription']);
                    $(e).after(elem);
                    $(e).html('Edit');
                }
            });
        }

    </script>
</html>
