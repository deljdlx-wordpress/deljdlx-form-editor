<?php

use Deljdlx\FormEditor\Controllers\FormEditor;
use Deljdlx\FormEditor\Controllers\FormTreeEditor;
use Illuminate\Http\Request;

$router->get('/deljdlx-form-editor/form', function () {
    $controller = new FormEditor($this->container);
    return $controller->form();
});


$router->addRoute(['GET', 'POST', 'DELETE', 'PATCH'], '/deljdlx-form-editor/edit-form', function(Request $request) {
    $controller = new FormTreeEditor($this->container);
    return $controller->edit();
});
