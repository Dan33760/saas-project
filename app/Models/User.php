<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Store;
use App\Models\Panier;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //-- Relation One To Many (Plusieurs Stores pour un Utilisateur)
    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    //-- Relation One To Many (Plusieurs Paniers pour un Utilisateur)
    public function paniers()
    {
        return $this->hasMany(Panier::class);
    }

    //-- Relation One To One (Un User possede Une Image)
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    //-- Relation Many To Many (Un User peut Utiliser plusieurs Store)
    public function stores_user()
    {
        return $this->belongsToMany(Store::class, 'store_user', 'user_id', 'store_id')->withPivot('id', 'active', 'created_at');
    }
}
