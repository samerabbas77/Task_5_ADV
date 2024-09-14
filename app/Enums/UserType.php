<?php

namespace App\Enums;

enum UserType: string {
    case Admin = 'admin';
    case Manager = 'manager';
    case User = 'user';
}
