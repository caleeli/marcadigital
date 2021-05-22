<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $fillable = [
        'image',
        'title',
        'organization',
        'organization_url',
        'place',
        'date',
        'width',
        'style',
    ];

    protected $casts = [
        'image' => 'array',
    ];
/*
    public function save(array $options = [])
    {

        return parent::save($options);
    }*/

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
