<?php

use App\Http\Middleware\SingleSession;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            SingleSession::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                $error=$e->validator->errors()->getMessages();
                return response()->json(['error'=>$error, 'code'=>Response::HTTP_UNPROCESSABLE_ENTITY,'success' => false],Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        });

        $exceptions->render(function (HttpException $e, Request $request) {
            if ($request->is('api/*')) {
                $code=$e->getStatusCode();
                $message=Response::$statusTexts[$code];
                return response()->json(['error'=>$message, 'code'=>$code,'success' => false],$code);
            }
        });
        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            if ($request->is('api/*')) {
                $model = strtolower(class_basename($e->getModel()));
                return response()->json(['error'=>"Does not exist any instance of {$model} with given id", 'code'=>Response::HTTP_NOT_FOUND,'success' => false],Response::HTTP_NOT_FOUND);
            }
        });

        $exceptions->render(function (AuthorizationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json(['error'=>$e->getMessage(), 'code'=>Response::HTTP_FORBIDDEN,'success' => false],Response::HTTP_FORBIDDEN);
            }
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json(['error'=>$e->getMessage(), 'code'=>Response::HTTP_UNAUTHORIZED,'success' => false],Response::HTTP_UNAUTHORIZED);
            }
        });

        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                $error=$e->validator->errors()->getMessages();
                return response()->json(['error'=>$error, 'code'=>Response::HTTP_UNPROCESSABLE_ENTITY,'success' => false],Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        });
    })->create();
