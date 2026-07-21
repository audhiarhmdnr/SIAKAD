<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MataKuliah extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'sks',
        'prodi_id'
    ];

    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class);
    }
}