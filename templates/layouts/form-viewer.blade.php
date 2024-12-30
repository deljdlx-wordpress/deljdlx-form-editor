@extends('layouts-new/common/default')

@section('page-content')


    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>

     <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>

    <link rel="stylesheet" href="https://releases.jquery.com/git/ui/jquery-ui-git.css">
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script> --}}



    <style>

        .ui-widget-header {
            border: none;
        }

        .ui-widget-content {
            border: none;
        }
        .ui-widget.ui-widget-content {
            border: none;
        }
        .ui-tabs .ui-tabs-nav {
            padding: 0;
        }

        /* .ui-tabs-vertical { width: 55em; } */
        .ui-tabs-vertical .ui-tabs-nav { /*padding: .2em .1em .2em .2em; float: left; width: 12em; */ }
        .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
        .ui-tabs-vertical .ui-tabs-nav li a { display:block; }
        .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active {
            padding-bottom: 0; padding-right: .1em; border-right-width: 1px;
            background-color: rgb(var(--pcl-primary-color-10));
        }
        .ui-tabs-vertical .ui-tabs-panel { padding: 0;}


        /* ============================================ */

        .create-entity-container fieldset {
            border: none;
        }

        .cluster-container {
            margin: 0;
            border: solid 2px rgb(var(--pcl-primary-color-10));
            background-color: #eee;
            border-radius: 0 1rem 1rem 0;
            overflow: hidden;
            padding: 1rem;
            gap: 1rem;
        }

        .attribute-container {
            padding: 1rem;
            height: 100%;
            background-color: #fff;
            border: solid 1px #ccc;
            border-radius: 1rem;
            box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.1);

            border: solid 2px #f0f;
        }

        .attribute-name {
            font-size: 16px;
            font-weight: bold;
        }

        .attribute-values-container {
            gap: 1rem;
        }

        /* ========================================== */

        .fields-group-container {
            display: flex;
            flex-direction: column;
            width: 100%
        }

        .subfield-container {
            background-color: #eee;
            position: relative;
            margin-bottom: 1rem;
            padding: 1rem;
        }

        .subfield-container--image {
            min-height: 120px;
        }

        .subfield-name {
            font-weight: bold;
        }

        .subfield-container:last-child {
            margin-bottom: 0;
        }

        /* ========================================== */



        .value-container {
            position: relative;
            padding: 0.5rem;
            background-color: #fff;
            border: solid 1px #ccc;
            border-radius: 1rem;
            box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.1);
        }

        .value-container--image {
            min-height: 120px;
        }



        .fieldset-header {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            background-color: #aaa;
            color: #fff;
            margin: -0.5rem -0.5rem 1rem -0.5rem;
            padding: 4px;
            border-radius: 1rem 1rem 0 0;
        }

        fieldset {
            position: relative;
        }



        .remove-value {
            position :absolute;
            right: 0;
            top: 0;
        }

        .attribute-button-reset-value {
            border: solid 1px #ccc;
            background-color: #fff;
            border-radius: 1rem 0 0 1rem;
            padding: 0 1rem;
        }

        .attribute-button-reset-value.attribute-button-reset-value--image {
            position: absolute;
            right: 4px;
            top: 4px;
            border-radius: 4px;
            padding: 0.5rem;
        }


        /* next element of type input */
        .attribute-button-reset-value + input {
            border-radius: 0 1rem 1rem 0;
        }

        .attribute-image-container {
            position: relative;
        }

        .wp-editor-wrap {
            width: 100%;
        }

        .acf-field {
            margin-bottom: 1rem;
            border-top: solid 1px #ccc;
        }

        .acf-field:first-of-type {
            border-top: none;
        }

        /* ============================================ */



        .button-choose-image {
            position: absolute;
            top: 4px;
            left: 4px;
        }


        /* ============================================ */


        .attribute-value--image {
            width: 100%;
            border: solid 1px;
        }

        .attribute-value--youtube-iframe {
            margin-top: 0.5rem;
            width: 100%;
            height: 400px;
        }

        .attribute-value--map-container {
            margin-top: 0.5rem;
            border: solid 1px;
            height: 500px;
            width: 100%;
        }

    </style>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
        jQuery( "#tabs" ).tabs(
            // listen change tab
            {
                activate: function( event, ui ) {
                    const mapContainers = document.querySelectorAll('.map-container');
                    for (let container of mapContainers) {
                        const map = container.map;
                        if (map) {
                            map.invalidateSize();
                        }
                    }
                }
            }
        ).addClass( "ui-tabs-vertical ui-helper-clearfix" );
        jQuery( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
    });

    </script>



    <section>
        <div class="flex justify-center">

            <script>



                document.addEventListener('alpine:init', () => {
                    const reactiveStore = Alpine.reactive(store);
                    Alpine.data('application', () => reactiveStore);

                    reactiveStore.loadDescriptor({!!$descriptor->getField('json')!!});

                    const values = {!!json_encode($values)!!};
                    reactiveStore.loadValues(values);
                });


            </script>

            <div class="create-entity-container container edit-entity-container pt-10" x-data="application" x-init="initializeMediaLibrary()">
                <div class="flex">
                    <button class="btn btn-primary debug" x-on:click="console.log(store)">Debug</button>
                    <button class="btn btn-primary save" x-on:click="save()">Save</button>
                </div>
                <input style="border: solid 1px #f0f" id="entity_id" type="hiddene" name="entity_id" value="{{ $entity->ID }}">


                <template x-if="store.descriptor">
                    <div class="row">
                        <div class="col-md-12">
                                <div id="tabs" class="w-full flex">
                                    <ul>
                                        <template x-for="(cluster, clusterIndex) in store.descriptor.children">
                                            <li><a :href="'#tabs-' + clusterIndex" x-html="cluster.text"></a></li>
                                        </template>
                                    </ul>
                                    <template x-for="(cluster, clusterIndex) in store.descriptor.children">
                                        <div :id="'tabs-' + clusterIndex" class="grow">
                                            <div x-html="renderCluster(cluster, clusterIndex)"></div>
                                        </div>
                                    </template>
                                </div>
                        </div>
                    </div>
                </template>


            </div>
    </section>


    <script>
        document.addEventListener('DOMContentLoaded', () => {

        });
    </script>
@endsection
