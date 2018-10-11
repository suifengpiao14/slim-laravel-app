# Slim 3 API 架构模板

这是API 框架模板，包含目录结构、错误处理，缓存，数据库连接，gitlab-ci自动发布等模块，可通过`config/dependencies.php` 增加自己的依赖


### 返回格式
返回数据格式由查询参数output（值为json或者xml）或者http "Accept"头信息决定
- 查询参数含output则有该参数决定，可能的值为`"json" or "xml"`
- 没有提供output 参数，则有HTTP 头 `"Accept"` 决定返回内容格式。如果Accept 不包含 "application/json"` or `"application/xml"` 则默认为`"json"`



### 测试:

1. `$ cd my-app`
2. `$ php -S 0.0.0.0:8888 -t public public/index.php`
3. 查看 http://localhost:8888

## 目录说明

* `app/`: 主要逻辑代码目录.
* `app/Controllers/`:  controllers 和 actions 类目录.
* `app/Handlers/`: 错误处理类目录.
* `app/Helpers/`: 帮助目录，含默认Helper类.
* `app/Middleware/`: 中间件.
* `app/Renders/`: 响应渲染目录 (json and xml).
* `bootstrap/`: 启动目录.
* `storage/cache/`: 缓存目录，需要可写权限.
* `storage/logs/`: 日志目录.
* `storage/cache/routes/`: 路由缓存目录，需要可写权限.
* `config/`: 配置文件目录 (settings, dependencies, middleware).
* `public/`: web入口目录.
* `routes/`: 路由目录.
* `tests/`: dphpunit 测试目录.
* `vendor/`: 第三方包目录.

## 文件说明

* `public/index.php`: 入口文件.
* `public/swagger-ui`: swagger文档ui静态资源.
* `bootstrap/app.php`: 启动框架，配置自动加载、依赖、路由等.
* `.env`: 正式环境配置文件.
* `.env.test`: 测试环境配置文件.
* `.env.dev`: 开发环境.
* `config/dependencies.php`: 依赖组件，包括 (数据库, 错误处理, 日志, 等等).
* `config/middleware.php`: 项目中间件.
* `config/settings.php`: 配置文件包含 (displayErrorDetails, routerCacheFile 等配置项).
* `routes/api.php`: 前端api路由.
* `routes/backend.php`: 后端api路由.
* `app/Controllers/Api/v1/ExampleController.php`: api v1 版本 ExampleController.php.
* `app/Controllers/Backend/v1/ExampleController.php`: 后台 v1 版本 ExampleController.php.
* `app/Controllers/Controller.php`: 控制器基类.
* `app/Controllers/SwaggerController.php`: api swagger文档类.
* `app/Helpers/ArrayToXml.php`: 协助将array转xml类. 
* `app/Renders/ApiView.php`: 基于PSR-7请求头.
* `app/Renders/JsonApiView.php`: json 返回格式 (包含错误代码). 返回 "meta" 和 "data". "meta" 包含 "error" (true/false) and "status" (HTTP Status code).
* `app/Renders/XmlApiView.php`: xml 返回格式(with error code). Return "meta" 和 "data". "meta" 包含 "error" (true/false) and "status" (HTTP Status code).
