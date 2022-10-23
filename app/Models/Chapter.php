<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class Chapter extends Model
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
        'content_id',
    ];

    protected $appends = [
        'currentUserFlash',
        'currentUserMemo',
        'memosCount',
        'flashesCount',
        'currentUserStatus',
        'statusesNowCount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function memos()
    {
        return $this->hasMany(Memo::class)->orderByDesc('created_at');
    }

    public function getMemosCountAttribute()
    {
        return $this->memos->count();
    }

    public function flashes()
    {
        return $this->hasMany(Flash::class)->orderByDesc('created_at');
    }

    public function getFlashesCountAttribute()
    {
        return $this->flashes->count();
    }

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    public function getCurrentUserMemoAttribute()
    {
        $memo = DB::table('memos')->where([
            'user_id' => Auth::id(),
            'chapter_id' => $this->id
            ])
            ->orderBy('created_at', 'desc')
            ->first();

        return $memo;
    }

    public function getCurrentUserFlashAttribute()
    {
        $flash = DB::table('flashes')->where([
            'user_id' => Auth::id(),
            'chapter_id' => $this->id
            ])
            ->orderBy('created_at', 'desc')
            ->first();

        return $flash;
    }

    public function getCurrentUserStatusAttribute()
    {
        $status = $this->statuses->where('user_id', '=', Auth::id())->first();

        return $status;
    }

    public function getStatusesNowCountAttribute()
    {
        return $this->statuses->where('value', '=', 'now')->count();
    }
}
