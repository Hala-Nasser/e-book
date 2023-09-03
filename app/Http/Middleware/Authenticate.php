<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        //يعني ازا الريكوست الي جاي ما بدو يرجعله جيسون (يعني الي طالب الريكوست متصفح ويب) روح اعرضله صفحة اللوقن
        return $request->expectsJson() ? null : route('dashboard.login');

        //نفس الي فوق بس باسلوب اوضح
        // if(! $request->expectsJson()){
        //     return route('dashboard.login');
        // }
    }
}
