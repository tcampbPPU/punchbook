<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    public static array $allowed = ['email', 'google', 'github'];

    protected $guarded = [];

    protected $casts = ['payload' => AsArrayObject::class];

    protected $hidden = ['payload.token'];
}
