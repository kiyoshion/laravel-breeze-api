<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class Content extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'title',
        'order',
        'user_id',
        'material_id',
    ];

    protected $appends = [
        'chaptersCount',
        'currentUserStatusDoneCount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class)->orderBy('order', 'asc');
    }

    public function getChaptersCountAttribute()
    {
        return $this->chapters->count();
    }

    public function getCurrentUserStatusDoneCountAttribute()
    {
        $chapters = $this->chapters;

        $total = 0;
        foreach($chapters as $chapter) {
            $total += DB::table('statuses as status')
                ->where('status.user_id', '=', Auth::id())
                ->where('status.value', '=', 'done')
                ->join('chapters as chap', function ($join) {
                    $join->on('status.chapter_id', '=', 'chap.id');
                })
                ->where('chap.id', '=', $chapter->id)
                ->count();
        }

        return $total;
    }
}
