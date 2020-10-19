@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-header bg-warning text-dark">
                       <h4> Question</h4>
                    </div>
                    <form action="{{ isset($post) ? '/post/update/'. $post->id : '/post'}}" method="POST">
                        @csrf
                        @if(isset($post))                                    
                            @method('patch')
                        @endif
                        <div class="card-body">
                            <div class="form-group row">
                                
                                <label for="question" class="col-form-label col-sm-3">Enter Question</label>
                                <div class="col-sm-9">
                                    <textarea type="text" name="question" id="question" class="form-control form-control-lg" rows="5" required>@isset($post){{$post->question}}@endisset</textarea>
                                </div>
                            </div>
                            <div class="card-footer bg-warning">
                                @if(isset($post))                                    
                                    <input type="submit" value="Update">
                                @else
                                    <button class="btn btn-success text-white">Post</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
