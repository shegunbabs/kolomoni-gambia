<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'phone', 'status',
        'password', 'tin', 'dob', 'email_verified_at', 'otp_secret',
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


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// ACCESSORS & MUTATORS
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function fullname(): Attribute {
        return Attribute::make(
            get: fn() => ucwords("{$this->lastname} {$this->firstname}"),
        );
    }


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// RELATIONSHIPS
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function devices(): HasMany {
        return $this->hasMany(Device::class);
    }


    public function account(): HasOne {
        return $this->hasOne(Account::class);
    }
}
