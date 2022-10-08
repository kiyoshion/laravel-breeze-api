<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'title',
        'type_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
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
        return $this->belongsToMany(Room::class);
    }
}
