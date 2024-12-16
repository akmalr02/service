<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // Tabel yang terkait dengan model
    protected $table = 'tickets';

    // Kolom yang dapat diisi secara massal
    protected $guarded = [
        'id'
    ];

    // Relasi ke model User untuk user yang membuat tiket
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke model User untuk teknisi
    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
