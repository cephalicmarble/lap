<?php

namespace App\Http\Middleware;

use Closure;

use Symfony\Component\HttpKernel\TerminableInterface as TerminableInterface;
use App\Jobs\ProcessLazyAggregatePromises;
use App\Lap;

class FireLazyAggregatePromises implements TerminableInterface
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
	
	public function terminate(Request $request, Response $response)
	{
		dispatch((new ProcessLazyAggregatePromises(Lap::$tabled_laps))->onQueue("sync"));
	}
}
