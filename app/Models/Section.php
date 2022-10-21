<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

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
        'currentUserOutputs',
        'currentUserStatus',
        'currentUserStatusDoneCount',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function outputs()
    {
        return $this->hasMany(Output::class)->orderByDesc('created_at');
    }

    public function getOutputCountAttribute()
    {
        return $this->outputs->count();
    }

    public function flashes()
    {
        return $this->hasMany(Flash::class)->orderByDesc('created_at');
    }

    public function statuses()
    {
        return $this->hasMany(Status::class);
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

    public function getCurrentUserOutputsAttribute()
    {
        $section_id = $this->id;
        $user_id = Auth::id();
        $outputs = [];

        $outputs = DB::table('outputs')->where([
            'user_id' => $user_id,
            'section_id' => $section_id
            ])
            ->orderBy('created_at', 'desc')
            ->first();

        return $outputs;
    }

    public function getCurrentUserStatusAttribute()
    {
        $status = $this->statuses->where('user_id', '=', Auth::id())->first();

        return $status;
    }

    public function getCurrentUserStatusDoneCountAttribute()
    {
        $status = $this->statuses->where('user_id', '=', Auth::id())->where('value', '=', 'done')->where('section_id', '=', $this->parent_id)->count();

        return $status;
    }
}
