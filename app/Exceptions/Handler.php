<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Throwable;
use ReflectionClass;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $e, $request)
        {
            if (\auth()->check())
            {
                return $this->formatResponseError($e);
            }
        });

        $this->reportable(function (Throwable $e)
        {
            //
        });
    }

    public function report(Throwable $exception)
    {
        if ($this->shouldReport($exception) && app()->bound('sentry'))
        {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }


    protected function formatResponseError(Throwable $e)
    {
        $response = [
            'errors' => $e->getMessage() ?? config('env.MSG_ERROR'),
            'line'    => $e->getLine(),
            'trace'   => $e->getTrace(),
        ];

        if ($e instanceof QueryException)
        {
            $response['errors'] =  "Une erreur s'est produite au niveau de la base de donnée";
            $response['errors'] = $e->getMessage() ?? config('env.MSG_ERROR');
        }

        if (($e instanceof ValidationException))
        {
            $errors = null;
            if ($e->errors()) {
                $messages = array_values($e->errors());
                [$errors] = array_shift($messages);
            }

            //$response['errors'] = "Les informations fournies ne sont pas valide";
            $response['errors'] = $errors;
        }

        if ($e instanceof NotFoundHttpException)
        {
            $e = $e->getPrevious();
            if ($e instanceof ModelNotFoundException)
            {
                $modelRefl = new ReflectionClass($e->getModel());

                $response['message'] = "Donnée introuvable";
                $response['errors'] = "L'élement recherché n'existe pas dans " . str_replace('-', ' ', Str::kebab($modelRefl->getShortName()));
                return response()->json(['data' => $response], 200);
            }
        }

        if (!($e instanceof AuthenticationException) && !($e instanceof NotFoundHttpException))
        {
            return response()->json(['data' => $response], 200);
        }
    }
}
