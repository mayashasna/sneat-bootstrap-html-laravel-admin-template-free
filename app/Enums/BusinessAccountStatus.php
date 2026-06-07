<?php

namespace App\Enums;

enum BusinessAccountStatus: string
{
    case Pending  = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
}
