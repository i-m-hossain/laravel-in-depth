<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CustomRouteListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:custom-route-list-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
{
    $routes = app('router')->getRoutes();

    $this->displayRoutes($routes);
}

protected function displayRoutes($routes)
{
    $headers = ['Method', 'URI', 'Name', 'Action', 'Middleware'];

    $rows = [];

    foreach ($routes as $route) {
        $methods = implode('|', $route->methods());
        $uri = $route->uri();
        $name = $route->getName();
        $action = $route->getActionName();
        $middlewares = $this->getRouteMiddlewares($route);

        $middleware = implode(', ', $middlewares);

        if ($middleware === '') {
            $middleware = '-';
        }

        $rows[] = [
            $methods,
            $uri,
            $name !== null ? $name : '-',
            $action !== null ? $action : '-',
            $middleware
        ];
    }

    $this->table($headers, $rows);
}

protected function getRouteMiddlewares($route)
{
    $action = $route->getAction();

    if (isset($action['withoutMiddleware']) && is_array($action['withoutMiddleware'])) {
        return array_diff($route->gatherMiddleware(), $action['withoutMiddleware']);
    }

    return $route->gatherMiddleware();
}

}
