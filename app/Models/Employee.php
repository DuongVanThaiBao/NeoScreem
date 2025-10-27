<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'department', 'position', 'phone', 'email', 'status', 'active',
        'gender', 'dob', 'address', 'cccd', 'start_date', 'base_salary',
        'bank_account', 'bank_name', 'avatar',
    ];
}
