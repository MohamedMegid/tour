<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/*/admin/sections-bulk',
        '/*/admin/sites-bulk',
        '/*/admin/news-bulk',
        '/*/admin/events-bulk',
        '/*/admin/banners-bulk',
        '/*/admin/palbum-bulk',
        '/*/admin/videos-bulk',
        '/*/admin/pages-bulk',
        '/*/admin/implinks-bulk',
        '/*/admin/contacts-bulk',
        '/*/admin/complains-sections-bulk',
        '/*/admin/complains-bulk',
        '/*/admin/comments-bulk',
        '/*/admin/users-bulk',
		'/*/admin/reviews-bulk',
        '/*/admin/area-bulk',
        '/*/admin/city-bulk',
		'/*/admin/complains-sections-bulk',
    ];
}
