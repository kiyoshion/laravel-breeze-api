<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    protected $appends = [
        'fullPathPoster',
        'parentSectionCount',
        'childrenSectionCount',
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

    public function getFullPathPosterAttribute()
    {
        return Storage::url($this->poster);
    }

    public function getParentSectionCountAttribute()
    {
        return $this->sections->where('level', '=', 0)->count();
    }

    public function getChildrenSectionCountAttribute()
    {
        return $this->sections->where('level', '=', 1)->count();
    }
}
