<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'lang',
        'parent_id',
        'label_parent',
        'label_child',
    ];

    public function materials()
    {
        return $this->hasMany(Type::class);
    }
}
