<?php

namespace App\Constants;

enum ProductStatus: string
{
    case DRAFT  = 'draft';
    case PENDING  = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case DISABLED = 'disabled';
    case ENABLED  = 'enabled';
}
