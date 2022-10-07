<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Section extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'title',
        'order',
        'level',
        'material_id'
    ];

    protected $appends = [
        'outputCount',
        'flashCount',
        'parentSection',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function outputs()
    {
        return $this->hasMany(Output::class);
    }

    public function getOutputCountAttribute()
    {
        return $this->outputs->count();
    }

    public function flashes()
    {
        return $this->hasMany(Flash::class);
    }

    public function getFlashCountAttribute()
    {
        return $this->flashes->count();
    }

    public function getParentSectionAttribute()
    {
        $parentSection = DB::table('sections')->where('id', '=', $this->parent_id)->first();

        return $parentSection;
    }
}
