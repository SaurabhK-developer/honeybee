<?php

namespace App;

use App\Marketplace\Listing as MarketplaceListing;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    public function setPasswordAttribute($password)
    {
        if ($password) {
            $this->attributes['password'] = app('hash')->needsRehash($password)
                ? app('hash')->make($password)
                : $password;
        }
    }

    public function marketplaceListings()
    {
        return $this->hasMany(MarketplaceListing::class, 'user_id');
    }
}
