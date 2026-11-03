<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitRecord extends Model
{
    protected $fillable = [
        'pet_id',
        'vet_id',
        'appointment_id',
        'visit_date',
        'reason',
        'diagnosis',
        'treatment',
        'notes',
    ];

    protected function casts(): array
    {
        return ['visit_date' => 'date'];
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function vet(): BelongsTo
    {
        return $this->belongsTo(Vet::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
