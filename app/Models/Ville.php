<?php

namespace App\Models;

use App\Models\Pays;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ville extends Model
{
    use HasFactory;

    //-- Relation One To Many (Un pays possede plusieurs ville)
    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }
}
