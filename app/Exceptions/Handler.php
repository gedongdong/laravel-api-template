<?php

namespace App\Exceptions;

use App\Api\Helpers\ExceptionReport;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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

    public function render($request, Throwable $exception)
    {
        //ajax请求我们才捕捉异常
        if ($request->ajax()) {
            if (env('APP_DEBUG')) {
                //开发环境，则显示详细错误信息
                return parent::render($request, $exception);
            }

            // 将方法拦截到自己的ExceptionReport
            $reporter = ExceptionReport::make($exception);
            if ($reporter->shouldReturn()) {
                return $reporter->report();
            }

            //线上环境,未知错误，则显示500
            return $reporter->prodReport();
        }
        return parent::render($request, $exception);
    }
}
