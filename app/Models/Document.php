<?php

namespace App\Models;

use App\Models\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    //-- Relation One To Many (Un document Pour Un Store)
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
