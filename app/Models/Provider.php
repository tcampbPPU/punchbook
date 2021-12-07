<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Provider extends Model
{
    public static array $allowed = ['email', 'google', 'github'];
    protected $guarded = [];
    protected $casts = ['payload' => AsArrayObject::class];
    protected $hidden = ['payload.token'];
}
