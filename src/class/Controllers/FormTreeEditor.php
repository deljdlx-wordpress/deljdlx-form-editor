<?php
namespace Deljdlx\FormEditor\Controllers;

use Deljdlx\TreeEditor\Controllers\TreeEditor;

class FormTreeEditor extends TreeEditor
{
    public string $editorTemplate ='layouts.form-editor';
    public string $defaultStore = 'plugin://deljdlx-form-editor/assets/js/form-editor/default-store.js';
    public string $defaultNodeTypes = 'plugin://deljdlx-form-editor/assets/js/form-editor/node-types.js';
    public string $nodeInformationsTemplate = 'partials.form-editor.node-informations';


    public static $prependCss = [
        'https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css',
        'plugin://deljdlx-tree-editor/assets/vendor/jstree/jstree.min.css',
        'plugin://deljdlx-form-editor/assets/css-compiled/form-editor.css',
    ];
}
