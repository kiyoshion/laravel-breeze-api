<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Auth;

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
        'contentsCount',
        'contentsChaptersCount',
        'fullPathPoster',
        'joinsUserCount',
        'joinsCurrentUserTopic',
        'topicsUserCount',
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

    public function memos()
    {
        return $this->hasMany(Memo::class);
    }

    public function flashes()
    {
        return $this->hasMany(Flash::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }

    public function joins()
    {
        return $this->hasMany(Join::class)->orderByDesc('created_at');
    }

    public function contents()
    {
        return $this->hasMany(Content::class)->orderBy('order', 'asc');
    }

    public function getFullPathPosterAttribute()
    {
        return Storage::url($this->poster);
    }

    public function getContentsCountAttribute()
    {
        return $this->contents->count();
    }

    public function getContentsChaptersCountAttribute()
    {
        $total = 0;
        foreach($this->contents as $content) {
            $total += count($content->chapters);
        }

        return $total;
    }

    public function getJoinsUserCountAttribute()
    {
        return $this->joins->count();
    }

    public function getJoinsCurrentUserTopicAttribute()
    {
        return $this->joins->where('user_id', Auth::id())->first();
    }

    public function getTopicsUserCountAttribute()
    {
        $tmp = [];
        $topics = $this->topics;
        foreach($topics as $topic) {
            $tmp[] = [
                'id' => $topic['id'],
                'name' => $topic['name'],
                'count' => $this->joins->where('topic_id', $topic['id'])->count()
            ];
        }

        return $tmp;
    }

}
