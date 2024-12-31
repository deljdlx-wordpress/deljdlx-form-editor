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
                                        <div :id="'tabs-' + clusterIndex" class="grow" x-data="cluster">

                                            <div class="cluster-container grid grid-cols-12">

                                                <template x-for="(attributeDescriptor, attributeIndex) in cluster.children">
                                                    <div class="attribute-container" :class="getAttributeContainerCssClass(attributeDescriptor)">

                                                        <h3 class="attribute-name">
                                                            <i class="ri-error-warning-line" x-show="attributeDescriptor.data.mandatory"></i>
                                                            <span  x-html="attributeDescriptor.text"></span>
                                                        </h3>


                                                        <div class=" attribute-values-container grid grid-cols-12">
                                                            {{-- <div
                                                                class="
                                                                    value-container
                                                                "
                                                                :class="
                                                                    'value-container--' + attributeDescriptor.data.code +
                                                                    ' value-container--' +attributeDescriptor.data.code +
                                                                    (attributeDescriptor.data.type === 'fields-group'
                                                                        ? ' col-span-' + attributeDescriptor.data.width
                                                                        : ' col-span-12'
                                                                    )
                                                                "
                                                            > --}}
                                                                <template x-if="attributeDescriptor.data.type !=='fields-group'">
                                                                    @include('partials.form-viewer.attribute-field')
                                                                </template>
                                                                <template x-if="attributeDescriptor.data.type ==='fields-group'">
                                                                    @include('partials.form-viewer.fields-group')
                                                                </template>
                                                            {{-- </div> --}}
                                                        </div>

                                                        {{-- Repeat field part --}}
                                                        <template x-if="attributeDescriptor.data.repeat">
                                                            <div class="mt-4">
                                                                <button
                                                                    x-on:click="repeatField(attributeDescriptor.data.code)"
                                                                    class="btn repeat"
                                                                >
                                                                    <i class="ri-add-circle-line"></i>
                                                                </button>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                        </div>
                    </div>
                </template>
            </div>
    </section>


    <script>
        document.addEventListener('alpine:init', () => {
            const reactiveStore = Alpine.reactive(store);
            Alpine.data('application', () => reactiveStore);

            reactiveStore.loadDescriptor({!!$descriptor->getField('json')!!});

            const values = {!!json_encode($values)!!};
            reactiveStore.loadValues(values);
        });
    </script>

@endsection

