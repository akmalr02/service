<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    // Relasi dengan model User sebagai teknisi
    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(ServiceStatus::class, 'status_id');
    }

    public function ticket(): HasOne
    {
        return $this->hasOne(Ticket::class);
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class);
    }

    // Event untuk menetapkan nilai default status_id
    protected static function booted()
    {
        static::creating(function ($service) {
            if (empty($service->status_id)) {
                // Mengatur default status_id ke ID tertentu, misalnya "4"
                $service->status_id = ServiceStatus::firstOrCreate(
                    ['id' => 1], // ID status default
                    ['name' => 'Default Status'] // Nama status jika belum ada
                )->id;
            }
        });
    }
}
