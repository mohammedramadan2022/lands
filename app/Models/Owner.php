<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Milon\Barcode\DNS1D;

class Owner extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [
        'id'
    ];

    protected $appends = ['barcode'];

    public function getBarcodeAttribute()
    {

        $clean = preg_replace('/[a-zA-Z]/', '', $this->register_number);
//        $clean = $this->register_number;

        return $clean;
        return "<img class='barcode' id='enable_reader' src='data:image/png;base64,".(new DNS1D)->getBarcodePNG($clean, 'C39', showCode: false)."'>";
    }

    public function freeCamels()
    {
        return $this->hasMany(Camel::class)->where('payment_code', 'free');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function camels()
    {
        return $this->hasMany(Camel::class);
    }

    public function trainers()
    {
        return $this->hasMany(Trainer::class);
    }

    public function modammers()
    {
        return $this->hasMany(Modammer::class);
    }

}
