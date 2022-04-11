{{-- @inject('markdown', 'Parsedown')
@php
    // TODO: There should be a better place for this.
    $markdown->setSafeMode(true);
@endphp --}}

<div id="comment-{{ $comment->getKey() }}" class="media mt-2">

    {{-- https://www.gravatar.com/avatar/{{ md5($comment->commenter->email ?? $comment->guest_email) }}.jpg?s=64 --}}

    <a href="{{ route('user.show', $comment->commenter->id) }}" class="text-decoration-none">
        <img class="rounded-circle mr-3" src="{{ $comment->commenter->getProfileImg() }}" 
        alt="{{ $comment->commenter->name ?? $comment->guest_name }} Avatar"
        width="40" height="40">
    </a>

    <div class="media-body">
        <div class="d-flex align-items-center gap-3">
            <span>
                <a href="{{ ($comment->commenter->isReader()) ? route('user.show', $comment->commenter->id) : 
                route('author.show', $comment->commenter->id) }}" class="text-decoration-none">
                    <small class="d-block">
                        @if ($comment->commenter->subscribed('default'))
                            <i class="fi fi-rr-diamond text-grandient"></i>
                        @endif
                        {{ ucwords($comment->commenter->name ?? $comment->guest_name) }}
                    </small>
                </a>
                <small class="text-muted d-block text-uppercase" style="font-size: 12px;">
                    {{ $comment->created_at->diffForHumans() }}
                </small>
            </span>
        </div>

        <span class="d-block mt-3">{!! $comment->comment !!}</span>

        <div class="text-capitalize mt-2" style="font-size: 14px;">
            @can('reply-to-comment', $comment)
                <a href="javascript:void(0)" data-toggle="modal" data-target="#reply-modal-{{ $comment->getKey() }}" class="text-secondary text-decoration-none mr-1">@lang('comments::comments.reply')</a>
            @endcan

            @can('edit-comment', $comment)
                <a href="javascript:void(0)" data-toggle="modal" data-target="#comment-modal-{{ $comment->getKey() }}" class="text-secondary text-decoration-none">@lang('comments::comments.edit')</a>
            @endcan
            
            @can('delete-comment', $comment)
                <a href="{{ route('comments.destroy', $comment->getKey()) }}" onclick="event.preventDefault();document.getElementById('comment-delete-form-{{ $comment->getKey() }}').submit();" class="text-danger text-decoration-none mx-1">@lang('comments::comments.delete')</a>

                <form id="comment-delete-form-{{ $comment->getKey() }}" action="{{ route('comments.destroy', $comment->getKey()) }}" method="POST" style="display: none;">
                    @method('DELETE')
                    @csrf
                </form>
            @endcan
        </div>

        @can('edit-comment', $comment)
            <div class="modal fade" id="comment-modal-{{ $comment->getKey() }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('comments.update', $comment->getKey()) }}">
                            @method('PUT')
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title text-uppercase">@lang('comments::comments.edit_comment')</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    {{-- <label for="message">@lang('comments::comments.update_your_message_here')</label> --}}
                                    <textarea required class="form-control" name="message" rows="3">{{ $comment->comment }}</textarea>
                                    {{-- <small class="form-text text-muted">@lang('comments::comments.markdown_cheatsheet', ['url' => 'https://help.github.com/articles/basic-writing-and-formatting-syntax'])</small> --}}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-outline-secondary text-uppercase" data-dismiss="modal">@lang('comments::comments.cancel')</button>
                                <button type="submit" class="btn btn-sm btn-outline-success text-uppercase">@lang('comments::comments.update')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan

        @can('reply-to-comment', $comment)
            <div class="modal fade" id="reply-modal-{{ $comment->getKey() }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('comments.reply', $comment->getKey()) }}">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title text-uppercase">@lang('comments::comments.reply_to_comment')</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    {{-- <label for="message">@lang('comments::comments.enter_your_message_here')</label> --}}
                                    <textarea required class="form-control" name="message" rows="3"></textarea>
                                    {{-- <small class="form-text text-muted">@lang('comments::comments.markdown_cheatsheet', ['url' => 'https://help.github.com/articles/basic-writing-and-formatting-syntax'])</small> --}}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-outline-secondary text-uppercase" data-dismiss="modal">@lang('comments::comments.cancel')</button>
                                <button type="submit" class="btn btn-sm btn-outline-success text-uppercase">@lang('comments::comments.reply')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan

        <br/>

        <?php
            if (!isset($indentationLevel)) {
                $indentationLevel = 1;
            } else {
                $indentationLevel++;
            }
        ?>

        {{-- Recursion for children --}}
        @if($grouped_comments->has($comment->getKey()) && $indentationLevel <= $maxIndentationLevel)
            {{-- TODO: Don't repeat code. Extract to a new file and include it. --}}
            @foreach($grouped_comments[$comment->getKey()] as $child)
                @include('comments::_comment', [
                    'comment' => $child,
                    'grouped_comments' => $grouped_comments
                ])
            @endforeach
        @endif

    </div>

</div>

{{-- Recursion for children --}}
@if($grouped_comments->has($comment->getKey()) && $indentationLevel > $maxIndentationLevel)
    {{-- TODO: Don't repeat code. Extract to a new file and include it. --}}
    @foreach($grouped_comments[$comment->getKey()] as $child)
        @include('comments::_comment', [
            'comment' => $child,
            'grouped_comments' => $grouped_comments
        ])
    @endforeach
@endif