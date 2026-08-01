<?php

namespace App\Enums;

enum CarStatus: string
{
    case DRAFT = 'draft';

    case PENDING_REVIEW = 'pending_review';

    case PUBLISHED = 'published';

    case PAUSED = 'paused';

    case DELETED = 'deleted';
}
