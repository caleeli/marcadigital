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
        'rotation',
        'qrcode',
    ];

    protected $casts = [
        'image' => 'array',
        'rotation' => 'int',
    ];

    protected static function booted()
    {
        static::creating(function (Certification $model) {
            $model->id = \intval(\microtime(true) * 2000000) + \rand(0, 999);
        });
        static::saving(function (Certification $model) {
            $model->favicon = $model->getFavIcon();
            $model->credential_id = $model->getCredentialId();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCredentialId()
    {
        $md5Id = \md5("{$this->id}");
        $md5Image = \md5(\json_encode($this->image));
        $md5Organization = \md5($this->organization, true);
        $id = \strtoupper(substr($md5Id, 0, 4));
        $cert = \hexdec(substr($md5Image, 0, 8));
        $org = substr(\base64_encode($md5Organization), 0, 4);
        return "{$id}-{$cert}-{$org}";
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
        if (!isset($parsed['scheme'])) {
            return;
        }
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

    public function validation()
    {
        return [
            'image' => 'required',
            'title' => 'required',
            'organization' => 'required',
            'organization_url' => 'required',
            'place' => 'required',
            'date' => 'required',
            'width' => 'required',
            'style' => 'required',
        ];
    }

    public function viewBox()
    {
        return $this->rotation == 0 || $this->rotation == 2 ? '0 0 210 279' : '0 0 279 210';
    }

    public function imageTransform()
    {
        switch ($this->rotation) {
            case 0:
              return '';
            case 1:
              return 'rotate(90 139.5 139.5)';
            case 2:
              return 'rotate(180 105 105)';
            case 3:
              return 'rotate(270 105 105)';
        }
    }

    public function imageWidth()
    {
        return 210;
    }

    public function imageHeight()
    {
        $filePath = \storage_path('app/public/' . $this->image['path']);
        $size = getimagesize($filePath);
        return $this->imageWidth() / $size[0] * $size[1];
    }
}
