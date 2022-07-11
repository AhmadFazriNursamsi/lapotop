<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Facades\Redirect;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if($this->isHttpException($e))
        {
            switch ($e->getStatusCode()) 
            {
                // not found
                case 404:
                return redirect("/404");
                break;

                // not found
                case 405:
                return redirect("/405");
                break;

                // internal error
                case '500':
                return redirect("/500");
                break;

                default:
                    return $this->renderHttpException($e);
                break;
            }
        }
        else
        {
            return parent::render($request, $e);
        }
    }
}
