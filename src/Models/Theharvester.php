<?php

namespace Ikay\TheharvesterService\Models;

use Ikay\TheharvesterService\Events\TaskTheharvesterCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Theharvester extends Model
{
    protected $table = 'theharvesters';
    
    protected $dispatchesEvents = [
        'created' => TaskTheharvesterCreated::class
    ];
    
    protected $fillable = [
        'user_id',
        'title',
        'domain',
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
    
    public function user()
    {
        return $this->belongsTo(config('theharvester-service.model'));
    }
}
