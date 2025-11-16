

<div>
    <div style="color: red">На ваш комметарий ответили!</div>
    <div>
        Ваш комментарий:
    </div>
    <div>
        {{ $parentComment->content }}
    </div>

    <div>
        Ответ на ваш комментарий
    </div>
    <div>
        {{ $comment->content }}
    </div>
</div>
