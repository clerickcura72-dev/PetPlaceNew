<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vet extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'license_number',
        'clinic_name',
        'approval_status',
        'working_days',
        'work_start',
        'work_end',
        'days_off',
    ];

    protected function casts(): array
    {
        return [
            'working_days' => 'array',
            'days_off'     => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
