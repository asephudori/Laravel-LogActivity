<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Mahasiswa extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['nim', 'nama', 'jurusan'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nim', 'nama', 'jurusan'])
            ->setDescriptionForEvent(fn(string $eventName) => "Mahasiswa {$this->nama} telah di-{$eventName}")
            ->logOnlyDirty(); // Hanya log field yang berubah
    }
}