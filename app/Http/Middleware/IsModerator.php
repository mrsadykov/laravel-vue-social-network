<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\DB;

class IsModerator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()->getName();
        if (!$routeName) {
            return response([
                'message' => 'forbidden'
            ], HttpResponse::HTTP_FORBIDDEN);
        }

        $routeNameArr = explode('.', $routeName);
        if (!$routeNameArr) {
            return response([
                'message' => 'forbidden'
            ], HttpResponse::HTTP_FORBIDDEN);
        }

        $modelName = $routeNameArr[0];
        if (!$modelName) {
            return response([
                'message' => 'forbidden'
            ], HttpResponse::HTTP_FORBIDDEN);
        }

        $attribute = 'is_moderator_' . $modelName;
        if (!auth()->user()->$attribute) {
            return response([
                'message' => 'controller forbidden'
            ], HttpResponse::HTTP_FORBIDDEN);
        }

        $action = $routeNameArr[1];
        //dd($action, auth()->user()->permissions());
        // all user permissions
        // $permisions = auth()->user()->roles->flatMap->permissions->pluck('title')->toArray();
        // dd($permisions);

        if (!$action || !in_array($action, auth()->user()->permissions())) {
            return response([
                'message' => 'action forbidden'
            ], HttpResponse::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
