<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response) use ($exceptions) {
            if ($response->getStatusCode() === 500) {
                return response()->json(['message' => 'error'], 500);
//                return view('errors/500');
//                return back()->with([
//                    'message' => 'The page expired, please try again.',
//                ]);
            }

            return $response;
        });
//        $exceptions->respond(function (Response $response) {
//            if ($response->getStatusCode() === 405) {
//                return back()->with([
//                    'message' => 'The page expired, please try again.',
//                ]);
//            }
//
//            return $response;
//        });
    })->create();
