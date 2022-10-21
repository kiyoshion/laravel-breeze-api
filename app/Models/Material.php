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
        'fullPathPoster',
        'joinsUserCount',
        'joinsCurrentUserTopic',
        'sectionsParentCount',
        'sectionsChildrenCount',
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

    public function getFullPathPosterAttribute()
    {
        return Storage::url($this->poster);
    }

    public function getSectionsParentCountAttribute()
    {
        return $this->sections->where('level', '=', 0)->count();
    }

    public function getSectionsChildrenCountAttribute()
    {
        return $this->sections->where('level', '=', 1)->count();
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

    public function getCurrentUserLastUpdateAttribute()
    {

    }
}
