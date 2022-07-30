<?php

namespace App\Exceptions;

use App\Mail\ExceptionOccuredMail;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

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
        $this->reportable(function (Throwable $e) {
            $this->sendEmail($e);
        });
    }

    public function sendEmail(Throwable $exception)
    {
        if(!getenv('REPORT_EXCEPTION') == "true"){
            return;
        }

        try {

            $content['message'] = $exception->getMessage();
            $content['file'] = $exception->getFile();
            $content['line'] = $exception->getLine();
            $content['trace'] = $exception->getTrace();

            $content['url'] = request()->url();
            $content['body'] = request()->all();
            $content['ip'] = request()->ip();
            $content['user'] = auth()->user() ? auth()->user()->name : 'N/A';

            Mail::to('cguzman@ibsaweb.com')->send(new ExceptionOccuredMail($content));
        } catch (Throwable $exception) {
            Log::error($exception);
        }
    }
}
