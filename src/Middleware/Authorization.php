<?php
declare (strict_types=1);

namespace ForeverEson\Permission\Middleware;

use Closure;
use think\exception\HttpException;
use think\Request;
use think\Response;

class Authorization
{
    /**
     * 登录权限检测
     *
     * @access public
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guest()) {
            throw new HttpException(401, '用户未登录');
        }

        $user = auth()->user(); // 登录用户
        $app = app('http')->getName(); // 应用模块
        $controller = $request->controller(true); // 控制器
        $action = $request->action(); // 方法
        $permission = $app . DIRECTORY_SEPARATOR . $controller . DIRECTORY_SEPARATOR . $action; // 权限名称
        if ($user->can($permission) === false) {
            throw new HttpException(403, '用户无权限');
        }

        return $next($request);
    }
}
