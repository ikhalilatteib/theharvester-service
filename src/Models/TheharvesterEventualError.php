<?php

namespace Ikay\TheharvesterService\Models;

use Illuminate\Database\Eloquent\Model;

class TheharvesterEventualError extends Model
{
    protected $table = 'theharvesters';

    protected $fillable = [
        'message',
        'code',
        'line',
        'file',
        'trace',
        'operation_time',
    ];
}
