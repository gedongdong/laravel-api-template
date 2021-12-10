<?php

return [
    // 注意：开启后，对于已经生成的token不起作用，只能等它自动刷新或重新登录
    'single_device_login' => env('SINGLE_DEVICE_LOGIN', false),
];
