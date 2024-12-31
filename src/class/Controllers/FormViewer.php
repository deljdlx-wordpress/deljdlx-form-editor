<?php
namespace Deljdlx\FormEditor\Controllers;

use Deljdlx\WPForge\Controllers\BaseController;
use \Deljdlx\TreeEditor\Models\Tree as Tree;
use WpPecule\Theme\PartnerProject;


class FormViewer extends BaseController
{
    public static $prependCss = [

    ];

    public static $appendJs = [

    ];

    public static $appendCss = [
        'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
        'https://releases.jquery.com/git/ui/jquery-ui-git.css',
        'plugin://deljdlx-form-editor/assets/css/form-viewer.css',
    ];

    public static $prependJs = [
        'plugin://deljdlx-form-editor/assets/js/form-viewer/FieldRenderer.js',
        'plugin://deljdlx-form-editor/assets/js/form-viewer/Store.js',
        'https://code.jquery.com/ui/1.14.1/jquery-ui.js',
        'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
    ];


    public function form(?Tree $descriptor = null, $entity = null, array $values = [])
    {
        wp_enqueue_editor();
        wp_enqueue_media();

        return $this->renderTemplate(
            'layouts.form-viewer',
            [
                'entity' => $entity,
                'descriptor' => $descriptor,
                'values' => $values
            ]
        );
    }
}

