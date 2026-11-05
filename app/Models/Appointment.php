<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'pet_id',
        'vet_id',
        'service',
        'appointment_date',
        'appointment_time',
        'reason',
        'status',
        'vet_note',
    ];

    protected function casts(): array
    {
        return ['appointment_date' => 'date'];
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function vet(): BelongsTo
    {
        return $this->belongsTo(Vet::class);
    }
}
