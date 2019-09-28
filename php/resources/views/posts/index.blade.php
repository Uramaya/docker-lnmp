@extends('layout')

@section('content')

<div class="container mt-4">

    <div class="mb-4">
        <a href="{{ route('posts.create') }}" class="btn btn-primary">
            投稿を新規作成する
        </a>
    </div>
    <form method="GET" action="/">
        @csrf
        <input type="text" name="word">
        <input type="submit" value="Search">
    </form>

    @if ( $word != "")
    <p>{{ $word }} </p>
    @endif

    <button type="button" class="button">connect to server by ajax</button>
    @foreach ($posts as $post)
    <div class="card mb-4">
        <div class="card-header">
            {{ $post->title }}
        </div>
        <div class="card-body">
            <p class="card-text">
                {!! nl2br(e(str_limit($post->body, 200))) !!}
            </p>
            <a class="card-link" href="{{ route('posts.show', ['post' => $post]) }}">
                続きを読む
            </a>
        </div>
        <div class="card-footer">
            <span class="mr-2">
                投稿日時 {{ $post->created_at->format('Y.m.d') }}
            </span>

            @if ($post->comments->count())
            <span class="badge badge-primary">
                コメント {{ $post->comments->count() }}件
            </span>
            @endif
        </div>
    </div>
    @endforeach
    <div class="d-flex justify-content-center mb-5">
        {{ $posts->appends([ 'word' => $word ])->links() }}
    </div>
</div>
<script>
    $(function() {
        $('.button').click(
            function() {
                $.ajax({
                    type: "GET",
                    url: "/",
                    data: {
                        name: "makino",
                        city: "yokohama"
                    },
                    success: function(data) {
                        alert(data);
                    },
                    error: function(data) {
                        alert('error');
                    }
                });
            }
        );
    });


    //                }).done(function(msg) {
    //                    alert("Success to connect! Your name is" + msg);
    //                });
    //    })
    //   });
</script>

@endsection