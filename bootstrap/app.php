<?php


use App\Http\Middleware\TwoFactorAuthMiddleware;
use App\Exceptions\Handler;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->web(TwoFactorAuthMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
/*         $exceptions->render(function (Throwable $exception) {
            return response()->view('errors.general', ['exception' => $exception], 500);
        }); */
    })->create();
