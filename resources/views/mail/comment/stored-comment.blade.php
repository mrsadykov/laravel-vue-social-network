

<div>
    <div style="color: red">{{ $post->title }}</div>
    <div>{{ $post->content }}</div>
    <div>
        Post {{ $post->id }} with new comment!
    </div>
    <div>
        Comment:
    </div>
    <div>
        {{ $comment->content }}
    </div>
</div>
