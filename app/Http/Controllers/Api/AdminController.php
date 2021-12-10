<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AdminRequest;
use App\Http\Resources\Api\AdminResource;
use App\Models\Admin;
use App\Models\Enum\AdminEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class AdminController extends Controller
{
    public function index()
    {
        //3个用户为一页
        return $this->success(AdminResource::collection(Admin::paginate(3)));
    }

    //返回单一用户信息
    public function show(Admin $user)
    {
        return $this->success(new AdminResource($user));
    }

    //用户注册
    public function store(AdminRequest $request)
    {
        Admin::create($request->validated());
        return $this->setStatusCode(201)->success('用户注册成功');
    }

    //用户登录
    public function login(Request $request)
    {
        //获取当前守护的名称
        $present_guard = Auth::getDefaultDriver();
        $token = Auth::claims(['guard' => $present_guard])->attempt(['name' => $request->name, 'password' => $request->password]);
        if ($token) {
            $admin = Auth::user();
            if ($admin && $admin->status !== AdminEnum::INVALID && $admin->status !== AdminEnum::FREEZE) {
                if(config('login.single_device_login')) {
                    // 启用单设备登录
                    // 注意：开启后，对于已经生成的token不起作用，只能等它自动刷新或重新登录
                    if ($admin->last_token) {
                        try {
                            Auth::setToken($admin->last_token)->invalidate();
                        } catch (TokenExpiredException $e) {
                            //因为让一个过期的token再失效，会抛出异常，所以我们捕捉异常，不需要做任何处理
                        }
                    }
                    $admin->last_token = $token;
                    $admin->save();
                }
                return $this->setStatusCode(201)->success(['token' => 'bearer ' . $token]);
            }
        }
        return $this->failed('用户登录失败', 401);
    }

    //用户退出
    public function logout()
    {
        Auth::logout();
        return $this->success('退出成功...');
    }

    //返回当前登录用户信息
    public function info()
    {
        $user = Auth::user();
        return $this->success(new AdminResource($user));
    }
}
