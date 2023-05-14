<?php

namespace Ikay\TheharvesterService\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Theharvester extends Model
{
    protected $table = 'theharvesters';

    protected $fillable = [
        'user_id',
        'title',
        'container',
        'description',
        'status',
    ];

    public function containers(): HasMany
    {
        return $this->hasMany(TheharvesterContainer::class);
    }

    public function errorLogs(): HasMany
    {
        return $this->hasMany(TheharvesterEventualError::class);
    }
}
