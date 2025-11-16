<?php

namespace App\Http\Middleware;

use App\Jobs\DbListenJob;
use App\Models\DbAction;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class DbListenMiddleware
{
    //protected $data = [];
    protected static $data;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // table -
        // status ?
        // message ?

        static::$data = [];

        DB::listen(function ($query) use ($request, &$data) {
            $sql = $query->toRawSql();
            if (!Str::contains($sql, 'db_actions')) {
                static::$data = [
                    'user_id' => $request->user()?->getJWTIdentifier(),
                    'sql' => $sql,
                    'duration' => $query->time,
                    'timestamp' => Carbon::now()->format('Y-m-d H:i:s'),
                    'route' => $request->route()?->getName()
                ];
            }
        });

        $response = $next($request);

        // Здесь мы можем вызывать задачу после выполнения следующего middleware
        DbListenJob::dispatch(static::$data);

        return $response;
    }
}
