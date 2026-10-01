<?php

use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\UnauthorizedAccessException;
use App\Http\Middleware\AuthToken;
use App\Http\Middleware\EnsureEmailIsVerified;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'inviteregister',
        ]);
         $middleware->alias([
            'auth.token' => AuthToken::class,
            'auth.emialverify' => EnsureEmailIsVerified::class,
        ]);

        $middleware->api(prepend: []);
    })
    
->withExceptions(function (Exceptions $exceptions): void {
        
         $exceptions->render(function (InvalidCredentialsException $e, Request $request) {
            return Response::error($e->getMessage(), $e->getStatusCode());
        });

        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
        $message =  $e->getMessage() ?: 'You are not authorized to perform this action.';
        return Response::error($message, 403);
        });

      

        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            $model = class_basename($e->getModel());

            return Response::error("{$model} not found.", 404);
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {

            $previous = $e->getPrevious();

        // Check if the 404 was caused by a missing Eloquent model
        if ($previous instanceof ModelNotFoundException) {
            $model = $previous->getModel();
            $ids = implode(', ', (array) $previous->getIds());

            return Response::error("Model not found {$model} {$ids}", 404);
        }
            $message = $e->getMessage() ?:'The requested resource does not exist.';
            return Response::error( $message, 404);
        });


    })->create();
