<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsensiTeknisi extends Model
{
    use HasFactory;

    protected $table = 'absensi_teknisi';

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(USer::class, 'user_id');
    }
}
