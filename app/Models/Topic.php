<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'lang',
    ];

    public function materials()
    {
        return $this->belongsToMany(Material::class);
    }

    public function joins()
    {
        return $this->hasMany(Join::class);
    }

    // public function getTopicUserCountAttribute()
    // {
    //     $results = $this->joins()->where('topic_id', $this->id)->count();
    // }
}
