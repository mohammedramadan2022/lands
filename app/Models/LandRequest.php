<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LandRequest extends Model
{
    use HasFactory;

    protected $table = 'land_requests';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $guarded = ['id'];

    protected $casts = [
        'birth_date' => 'date',
        'last_participation_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
