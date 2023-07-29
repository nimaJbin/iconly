<?php

namespace App\Enums;

enum UserSecurityStatus:string {
    case Verified   = 'verified';
    case UnVerified = 'unverified';
}
