<?php
namespace Deljdlx\FormEditor\Controllers;

use Deljdlx\WPForge\Controllers\BaseController;
use \Deljdlx\TreeEditor\Models\Tree as Tree;
use WpPecule\Theme\PartnerProject;


class FormEditor extends BaseController
{
    public static $prependCss = [

    ];

    public static $appendJs = [

    ];

    public static $appendCss = [
        'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
        'https://releases.jquery.com/git/ui/jquery-ui-git.css',
    ];

    public static $prependJs = [
        'plugin://deljdlx-form-editor/assets/js/Store.js',
        'https://code.jquery.com/ui/1.14.1/jquery-ui.js',
        'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
    ];


    public function form(?Tree $descriptor = null, $entity = null, array $values = [])
    {

        // if(!empty($_GET['save'])) {
        //     $json = file_get_contents('php://input');
        //     $data = json_decode(
        //         $json,
        //         true
        //     );

        //     $attributes = $data['attributes'];

        //     $store = $data['store'];
        //     $projectId = $data['projectId'];

        //     try {
        //         $project = new PartnerProject();
        //         if(!empty($projectId)) {
        //             $project = PartnerProject::find($projectId);
        //         }


        //         $project->setTitle($attributes['attribute-name']['values'][0]);
        //         $project->save();


        //         $project->setField('json', $attributes);

        //         return json_encode([
        //             'store' => $store,
        //             'project' => $project,
        //         ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        //     }
        //     catch(\Exception $e) {
        //         return json_encode([
        //             'error' => $e->getMessage(),
        //             'store' => $store,
        //             'attributes' => $attributes,
        //         ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        //     }
        // }

        wp_enqueue_editor();
        wp_enqueue_media();

        // if(!empty($_GET['project_id'])) {
        //     $project = PartnerProject::find($_GET['project_id']);
        //     $values = $project->getField('json');
        // }

        // dump($values);


        return $this->renderTemplate(
            'layouts.form',
            [
                'entity' => $entity,
                'descriptor' => $descriptor,
                'values' => $values
            ]
        );
    }
}

