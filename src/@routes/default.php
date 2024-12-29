<?php

use Deljdlx\FormEditor\Controllers\FormEditor;

$router->get('/deljdlx-form-editor/form', function () {
    $controller = new FormEditor($this->container);
    return $controller->form();
});

