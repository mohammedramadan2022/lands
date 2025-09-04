<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camel extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function owner()
    {
        // A camel belongs to an Owner via owner_id (UUID)
        return $this->belongsTo(Owner::class, 'owner_id');
    }
}
