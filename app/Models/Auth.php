<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
    protected $table = 'Users';
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'status',
        'picture'
    ];
}
