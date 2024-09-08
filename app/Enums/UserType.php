<?php

namespace App\Enums;

enum UserType: string {
    case Admin = 'admin';
    case Guest = 'manager';
    case User = 'user';
}
