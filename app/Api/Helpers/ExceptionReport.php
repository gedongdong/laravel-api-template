<?php

namespace App\Api\Helpers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class ExceptionReport
{
    use ApiResponse;

    /**
     * @var Throwable
     */
    public $exception;
    /**
     * @var Request
     */
    public $request;

    /**
     * @var
     */
    protected $report;

    /**
     * ExceptionReport constructor.
     * @param Request   $request
     * @param Throwable $exception
     */
    function __construct(Request $request, Throwable $exception)
    {
        $this->request = $request;
        $this->exception = $exception;
    }

    /**
     * @var array
     */
    //当抛出这些异常时，可以使用我们定义的错误信息与HTTP状态码
    //可以把常见异常放在这里
    public $doReport = [
        AuthenticationException::class       => ['未授权', 401],
        ModelNotFoundException::class        => ['该模型未找到', 404],
        AuthorizationException::class        => ['没有此权限', 403],
        ValidationException::class           => ['参数校验失败', 401],
        UnauthorizedHttpException::class     => ['未登录或登录状态失效', 422],
        TokenInvalidException::class         => ['token不正确', 400],
        NotFoundHttpException::class         => ['没有找到该页面', 404],
        MethodNotAllowedHttpException::class => ['访问方式不正确', 405],
        QueryException::class                => ['数据库参数错误', 401],
    ];

    public function register($className, callable $callback)
    {
        $this->doReport[$className] = $callback;
    }

    /**
     * @return bool
     */
    public function shouldReturn()
    {
        //只有请求包含是json或者ajax请求时才有效
        // if (! ($this->request->wantsJson() || $this->request->ajax())){
        //
        //     return false;
        // }
        foreach (array_keys($this->doReport) as $report) {
            if ($this->exception instanceof $report) {
                $this->report = $report;
                return true;
            }
        }

        return false;
    }

    /**
     * @param Throwable $e
     * @return static
     */
    public static function make(Throwable $e)
    {
        return new static(\request(), $e);
    }

    /**
     * @return mixed
     */
    public function report()
    {
        if ($this->exception instanceof ValidationException) {
            $error = [];
            foreach ($this->exception->errors() as $e) {
                foreach ($e as $item) {
                    $error[] = $item;
                }
            }
            return $this->failed(implode(',', $error), $this->doReport[$this->report][1]);
        }
        $message = $this->doReport[$this->report];
        return $this->failed($message[0], $message[1]);
    }

    public function prodReport()
    {
        return $this->failed('服务器错误', '500');
    }
}