<?php
namespace Deljdlx\FormEditor\Controllers;

use Deljdlx\TreeEditor\Controllers\TreeEditor;

class FormTreeEditor extends TreeEditor
{
    public string $editorTemplate ='layouts.form-editor';
    public string $defaultStore = 'plugin://deljdlx-form-editor/assets/js/form-editor/default-store.js';
    public string $defaultNodeTypes = 'plugin://deljdlx-form-editor/assets/js/form-editor/node-types.js';
    public string $nodeInformationsTemplate = 'partials.form-editor.node-informations';
}
