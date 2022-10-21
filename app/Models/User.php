<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'name',
        'email',
        'password',
        'displayname',
        'avatar',
        'profile',
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

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function outputs()
    {
        return $this->hasMany(Output::class);
    }

    public function flashes()
    {
        return $this->hasMany(Flash::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function joins()
    {
        return $this->hasMany(Join::class);
    }

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
}
