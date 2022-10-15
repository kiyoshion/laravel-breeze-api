<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flash extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'front_title',
        'front_description',
        'front_image',
        'back_title',
        'back_description',
        'back_image',
        'material_id',
        'section_id',
        'user_id'
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
