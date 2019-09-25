<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'title', 'description'
    ];

    protected $casts = [
        'created_at' => 'datetime:d.m.Y H:m',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
