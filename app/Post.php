<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{

    public $timestamps = true;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    protected $fillable = [
        'user_id', 'content',
    ];
    public function postMedia(): HasMany
    {
        return $this->hasMany('App\PostMedia');
    }
}
