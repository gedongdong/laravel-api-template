<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\Enum\UserEnum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class UserController extends Controller
{
    public function index()
    {
        //3个用户为一页
        return $this->success(UserResource::collection(User::paginate(3)));
    }

    //返回单一用户信息
    public function show(User $user)
    {
        return $this->success(new UserResource($user));
    }

    //用户注册
    public function store(UserRequest $request)
    {
        User::create($request->validated());
        return $this->setStatusCode(201)->success('用户注册成功');
    }

    //用户登录
    public function login(Request $request)
    {
        //获取当前守护的名称
        $present_guard = Auth::getDefaultDriver();
        $token = Auth::claims(['guard' => $present_guard])->attempt(['name' => $request->name, 'password' => $request->password]);
        if ($token) {
            $user = Auth::user();
            if ($user && $user->status !== UserEnum::INVALID && $user->status !== UserEnum::FREEZE) {
                if(config('login.single_device_login')) {
                    // 启用单设备登录
                    // 注意：开启后，对于已经生成的token不起作用，只能等它自动刷新或重新登录
                    if ($user->last_token) {
                        try {
                            Auth::setToken($user->last_token)->invalidate();
                        } catch (TokenExpiredException $e) {
                            //因为让一个过期的token再失效，会抛出异常，所以我们捕捉异常，不需要做任何处理
                        }
                    }
                    $user->last_token = $token;
                    $user->save();
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
        return $this->success(new UserResource($user));
    }
}
