<?php

namespace App\Enums;

enum PermissionGroup: string{
    case Products = 'products';
    case Categories = 'categories';
    case Orders = 'orders';
    case Admins = 'admins';
}
