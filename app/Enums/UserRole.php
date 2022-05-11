<?php
namespace App\Enums;

interface UserRole
{
    const SUPERADMIN     = 'Super Admin';
    const ADMIN     = 'Admin';
    const SHOPMANAGER = 'Shop Manager';
    const AFFILIATE  = 'Affiliate';
    const CUSTOMER  = 'Customer';
    const VENDOR  = 'Vendor';
}
