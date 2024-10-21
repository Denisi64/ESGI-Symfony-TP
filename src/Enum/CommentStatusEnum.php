<?php

namespace App\Enum;

enum CommentStatusEnum : string
{
    case ACCEPTED = 'accepted';
    case PENDING = 'pending';
    case REJECTED = 'rejected';

}

