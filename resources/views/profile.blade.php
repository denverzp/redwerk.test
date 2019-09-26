@extends('layouts.app')

@section('content')
    <div id="profile">

        <h1>Profile</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="name">Email</label>
                <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="name">Phone</label>
                <input type="text" id="phone" name="phone" value="{{ $user->phone }}" class="form-control" required>
            </div>

            <div class="form-group">
                @if($user->image)
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <img src="{{ $user->image }}" alt="" style="width: 200px; height: auto">
                        <button type="button" class="btn btn-sm btn-danger" id="remove-image">X</button>
                    </div>
                @else     
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image">
                @endif    
            </div>

            <hr>

            <p>Fill password fields only if you want update password</p>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>

            <div class="form-group">
                <label for="password_confirm">Repeat Password</label>
                <input type="password" id="password_confirm" name="password_confirm" class="form-control">
            </div>

            <hr>

            <div class="form-group text-right">
                <button type="submit" class="btn btn-outline-success">Update profile</button>
            </div>
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                (function($){
                    $('#remove-image').on('click', function(){

                        var token = document.head.querySelector('meta[name="csrf-token"]');

                        $.ajax({
                            url: '/profile/image',
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': token.content,
                                'Content-Type': 'application/json'
                            }
                        })
                        .done(function () {
                            location.reload();
                        })
                        .fail(function (xhr, errMsg) {
                            console.error(errMsg)
                        });
                    });
                })(jQuery);
            });
        </script>
    </div>
@endsection
