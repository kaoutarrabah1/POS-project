<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Global HTTP middleware stack
     * هاد الـ middlewares كيتشغلو على جميع الطلبات (الـ requests) بلا استثناء.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // Trust proxies (فـ حال كنت كتخدم ورا proxy)
        \App\Http\Middleware\TrustProxies::class,
        // Handle CORS (الصلاحيات ديال الاتصال من Frontend)
        \Illuminate\Http\Middleware\HandleCors::class,
        // منع الوصول فـ وقت الصيانة
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        // التحقق من حجم POST
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        // Trim strings (ت Trim لـ whitespace)
        \App\Http\Middleware\TrimStrings::class,
        // تحويل الفاضي لـ null
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * Middleware groups
     * هادو مجموعات الـ middleware اللي كتطبق على مجموعات معينة من routes (زي Web و API).
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        // group ديال routes اللي فـ web.php
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        // group ديال routes اللي فـ api.php
        'api' => [
            // هاد السطر ضروري لـ Sanctum باش يقدر يقرا التوكن من cookies (اختياري)
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            // throttle (تحديد عدد الطلبات)
            'throttle:api',
            // ربط parameters بالموديلات
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Route middleware
     * هادو الـ middlewares الفردية اللي تقدّر تطبقهم على route معينة (أو مجموعة).
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth'             => \App\Http\Middleware\Authenticate::class,
        'auth.basic'       => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers'    => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can'              => \Illuminate\Auth\Middleware\Authorize::class,
        'guest'            => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed'           => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle'         => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified'         => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        // ---------- هنا زدنا الـ middleware ديال roles ----------
        'role'             => \App\Http\Middleware\CheckRole::class,
    ];
}