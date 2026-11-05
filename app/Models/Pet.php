<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pet extends Model
{
    protected $fillable = [
        'pet_owner_id',
        'name',
        'type',
        'breed',
        'sex',
        'birth_date',
        'notes',
        'photo_path',
    ];

    protected function casts(): array
    {
        return ['birth_date' => 'date'];
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo_path ? asset('storage/' . $this->photo_path) : null;
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(PetOwner::class, 'pet_owner_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function visitRecords(): HasMany
    {
        return $this->hasMany(VisitRecord::class);
    }

    public function vaccinationRecords(): HasMany
    {
        return $this->hasMany(VaccinationRecord::class);
    }
}
