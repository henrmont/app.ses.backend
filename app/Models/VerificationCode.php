<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VerificationCode extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'expire_at',
        'code'
    ];
}
