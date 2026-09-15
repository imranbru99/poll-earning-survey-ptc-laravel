<?php $class = $thread->isUnread(Auth::id()) ? 'alert-info' : ''; ?>
<div class="text-nowrap bg-light border" style="width: 8rem;">
        <div class="media alert {{ $class }}">
            <h4 class="media-heading">
                <a href="{{ route('user.messages.show', $thread->id) }}">{{ $thread->subject }}</a>
                ({{ $thread->userUnreadMessagesCount(Auth::id()) }} unread)</h4>
            <p>
                {{ $thread->latestMessage->body }}
            </p>
            <p>
                <small><strong>Creator:</strong> {{ $thread->creator()->fullname }}</small>
            </p>
            <p>
                <small><strong>Participants:</strong> {{ $thread->participantsString(Auth::id()) }}</small>
            </p>
        </div>
</div>
