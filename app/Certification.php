<?php

namespace App;

use DOMDocument;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $organization_url
 */
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

    protected static function booted()
    {
        static::creating(function (Certification $model) {
            $model->id = \intval(\microtime(true) * 2000000) + \rand(0, 999);
        });
        static::saving(function (Certification $model) {
            $model->favicon = $model->getFavIcon();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFavIcon()
    {
        list($url, $page) = $this->getUrlContent($this->organization_url);
        if (!$page) {
            return \null;
        }
        $dom = new DOMDocument($page);
        @$dom->loadHTML($page);
        $links = $dom->getElementsByTagName('link');
        $iconPath = '/favicon.ico';
        foreach ($links as $link) {
            if ($link->getAttribute('rel') === 'icon') {
                $iconPath = $link->getAttribute('href');
                break;
            }
            if ($link->getAttribute('rel') === 'shortcut icon') {
                $iconPath = $link->getAttribute('href');
                break;
            }
        }
        [$url, $icon] = $this->getUrlContent($url, $iconPath);
        return $url;
    }

    public function getUrlContent($url, $path = null)
    {
        $parsed = \parse_url($url);
        if (!$path) {
            $path = $parsed['path'] ?? '';
        }
        $urlR = $parsed['scheme'] . '://' . $parsed['host'] . $path;
        if ($result = $this->testUrl($urlR)) {
            return [$urlR, $result];
        }
        $urlR = 'http://' . $parsed['host'] . $path;
        if ($parsed['scheme'] === 'https' && ($result = $this->testUrl($urlR))) {
            return [$urlR, $result];
        }
    }

    private function testUrl($url)
    {
        return @\file_get_contents($url);
    }
}
