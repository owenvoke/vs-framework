<?php

namespace VS\Framework\Routing;

use System\Route;

/**
 * Class RouteLoader
 */
class RouteLoader
{
    /**
     * @var array|null
     */
    public static $Modules;

    /**
     * RouteLoader constructor.
     */
    public function __construct()
    {
        $this->fetchModules();
    }

    /**
     * @param Route $Route
     * @return Route
     */
    public function autoload(Route $Route)
    {
        foreach (self::$Modules as $module) {
            $Route = $module->router::Register($Route);
        }

        return $Route;
    }

    /**
     * @return array
     */
    public function fetchModules()
    {
        $data = new \stdClass();
        $data->json = file_get_contents(ROOT_PATH . 'composer.json');
        $data->composer = json_decode($data->json);
        $data->response = [];

        foreach ($data->composer->require as $module => $version) {
            if (preg_match('/^(vs)\/(.*)$/im', $module, $results)) {
                $moduleMap = new \stdClass();
                $moduleMap->name = ucfirst($results[2]);
                $moduleMap->namespace = '\\VS\\' . $moduleMap->name;
                $moduleMap->router = '\\VS\\' . $moduleMap->name . '\\Routes';
                if (class_exists($moduleMap->router)) {
                    $data->response[] = $moduleMap;
                }
            }
        }

        self::$Modules = $data->response;

        return self::$Modules;
    }
}