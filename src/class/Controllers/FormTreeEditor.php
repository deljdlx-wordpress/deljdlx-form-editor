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
        // 'plugin://deljdlx-tree-editor/assets/vendor/jstree/jstree.min.css',
        'https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css',
        'plugin://deljdlx-form-editor/assets/css-compiled/form-editor.css',
        'https://releases.jquery.com/git/ui/jquery-ui-git.css',
    ];

    public static $prependJs = [
        'https://code.jquery.com/ui/1.14.1/jquery-ui.js',
    ];
}
