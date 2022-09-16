<?php

namespace App\Models;

use App\Models\User;
use App\Models\Produit;
use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name_store',
        'ref_store',
        'url_site',
        'url_affiliation',
        'email_notification',
        'email_assistance'
    ];

    //-- Relation One To Many (Un Store pour Un User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //-- Relation Many To Many (Plusieurs Clients Pour Un Store)
    public function clients()
    {
        return $this->hasMany(User::class, 'store_user', 'user_id', 'store_id')
                    ->withPivot('id', 'active', 'created_at');
    }

    //-- Relation One To Many (Un Store possede Plusieurs Produits)
    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    //-- Relation One To One Polymorphe (Un Store possede une Image)
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    //-- Relation One To Many (Un Store possede plusieurs Document)
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
