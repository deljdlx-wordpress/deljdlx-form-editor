<?php

namespace Deljdlx\FormEditor\Plugins;

use Deljdlx\TreeEditor\Models\Tree;
use Deljdlx\WPForge\Container;
use Deljdlx\WPForge\Plugin;
use Deljdlx\WPForge\Router;


class FormEditor extends Plugin
{

    public static $instance;

    public static function run()
    {
        $instance = static::getInstance();

        try {
            $result = $instance->router->route();

            if($result) {
                http_response_code(200);
                echo $result;
                return true;
            }
        }
        catch(\Exception $e) {
            dump($e);
        }
        return false;
    }

    public function __construct(Container $container,$bootstrapFile = null)
    {
        parent::__construct($container,$bootstrapFile);
        $this->router = Router::getInstance();

        $router = $this->router;
        include $this->filepath . '/src/@routes/default.php';
    }


    public function initialize()
    {
        global $wpdb;
        parent::initialize();
    }

    public function activate()
    {

    }
}
