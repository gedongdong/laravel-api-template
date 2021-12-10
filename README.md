## About Laravel-Api-Template

随着前后端完全分离，`PHP`也基本告别了`view`模板嵌套开发，转而专门写资源接口。`Laravel`是PHP框架中最优雅的框架，国内也越来越多人选择了`Laravel`。`Laravel`框架本身对`API`有支持，但是感觉再工作中还是需要再做一些处理。`Lumen`用起来不顺手，有些包不能很好地支持。所以，将`Laravel`框架进行一些配置处理，让其在开发`API`时更得心应手。
本模板基于Laravel8适配，调整点参考`@guaosi`大神的[项目](https://github.com/guaosi/Laravel_api_init)及[文档](https://learnku.com/articles/25947#reply211267)。

### 实现功能

* 解决跨域问题
* 统一Response响应处理
* Api-Resource资源返回
* 使用Enum枚举
* jwt-auth用户认证与无感知自动刷新
* jwt-auth多角色认证不串号
* 单一设备登陆

### 环境

* PHP >= 7.4
* Laravel8

### 安装

1. git clone https://github.com/gedongdong/laravel-api-template
2. composer install
3. cp .env.example .env（如需开启单一设备登录登录，设置 SINGLE_DEVICE_LOGIN=true）
4. php artisan key:generate
5. php artisan jwt:secret
6. php artisan migrate
7. php artisan db:seed

### 测试数据

users: user1 123456 user2 123456

admins: admin123 123456 admin124 123456