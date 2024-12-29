<?php
/*
Plugin Name: JDLX Form Editor
Version: 1
*/

namespace Deljdlx\FormEditor;

use Deljdlx\FormEditor\Plugins\FormEditor;
use Deljdlx\WPForge\Application;


$dependenciesErrors = false;

if(!is_dir(__DIR__ . '/../deljdlx-forge')) {
    // display a wordpress  error message
    add_action('admin_notices', function() {
        echo '<div class="error"><p>Plugin JDLX_Taverne requires JDLX_Forge plugin to be installed and activated.</p></div>';
    });

    $dependenciesErrors = true;
}

if(!is_dir(__DIR__ . '/../deljdlx-tree-editor')) {
    // display a wordpress  error message
    add_action('admin_notices', function() {
        echo '<div class="error"><p>Plugin JDLX_Taverne requires JDLX_TreeEditor plugin to be installed and activated.</p></div>';
    });

    $dependenciesErrors = true;
}

if($dependenciesErrors) {
    return;
}



if(!function_exists('acf_add_local_field_group')) {
    return;
}



require_once __DIR__ . '/../deljdlx-forge/jdlx-forge.php';
require_once __DIR__ . '/composer/autoload.php';

$container = Application::getInstance();
$container->addTemplatePath(__DIR__ . '/templates');
$container->loadComponentsFromFolder(
    __DIR__ . '/src/class/Components/',
    'Deljdlx\WPTaverne\Components',
);

$plugin = new FormEditor($container, __FILE__);
