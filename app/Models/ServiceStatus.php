<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class ServiceStatus extends Model
{
    use HasFactory;

    protected $table = 'service_status';

    protected $guarded = ['id'];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
