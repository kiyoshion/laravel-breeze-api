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

    protected $appends = [
        'joinsCount',
        // 'popularTopics',
    ];

    public function materials()
    {
        return $this->belongsToMany(Material::class);
    }

    public function joins()
    {
        return $this->hasMany(Join::class);
    }

    public function getJoinsCountAttribute()
    {
        return $this->joins->count();
    }

    public function getPopularTopicsAttribute()
    {
        $joinsCount = $this->joinsCount;
        // return $this->orderByDesc($this->getJoinsCountAttribute())->get();
        // $joins = $this->jons;
        // $joins = array_column($joins, 'joinsCount');
        // array_multisort($joins, SORT_DESC, $joins);

        // return $joins;
    }
}
