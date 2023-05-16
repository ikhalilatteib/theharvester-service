<?php

namespace Ikay\TheharvesterService\Models;

use Illuminate\Database\Eloquent\Model;

class TheharvesterEventualError extends Model
{
    protected $table = 'theharvester_eventual_errors';

    protected $fillable = [
        'message',
        'code',
        'line',
        'file',
        'trace',
        'operation_time',
    ];
}
