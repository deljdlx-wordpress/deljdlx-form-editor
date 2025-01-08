@extends('__core.layouts.empty')
@section('page-title')
    Form editor
@endsection

@section('body-content')


<div x-data="application" class="form-editor skill-tree-editor no-pcl-style">

    <div>

        <section class="skill-tree-editor__head">
            <div class="flex gap-2">
                <input id="skill-tree-name" name="skill-tree-name" type="text" class="skill-tree-name" placeholder=""  value="{{$skillTree->post_title}}"/>
                <button id="save-trigger" class="btn btn-primary btn-sm">Enregistrer</button>
            </div>
        </section>


        <section class="skill-tree-editor__content">
            <div id="tabs">
                <ul>
                <li><a href="#tabs-1">Edition</a></li>
                <li><a href="#tabs-2">Source</a></li>
                <li><a href="#tabs-3">Importer</a></li>
                </ul>



                <div id="tabs-1">
                    <div class="grid grid-cols-12 gap-2">
                        <div class="col-span-4 p-2 skill-tree__panel skill-tree__panel--left">
                            <div id="skill-tree"></div>

                            <div>
                                <input id="skillTreeId" value="{{$skillTree->ID}}" type="hidden">
                                <input id="skillTreePermalink" value="{{$skillTree->getPermalink()}}" type="hidden">
                            </div>
                        </div>

                        <div class="col-span-8 p-2 skill-tree__panel skill-tree__panel--right">
                            <template x-if="selectedNode">
                                @include($nodeInformationsTemplate)
                            </template>
                        </div>
                        {{-- <div class="col-span-6 p-2" style="border: solid 2px #f0f; min-height: 300px">
                            @include('partials.viewer')
                        </div> --}}
                    </div>
                </div>

                <div id="tabs-2" class="grid grid-cols-12 gap-2">
                    <div class="col-span-12 p-2" style="border: solid 2px #f0f; min-height: 300px">
                        <textarea style="width: 100%; height: 100%" x-text="JSON.stringify(treeData, null, 2)"></textarea>
                    </div>
                </div>

                <div id="tabs-3" class="grid grid-cols-12 gap-2">
                    <div class="col-span-12 p-2" style="border: solid 2px #f0f; min-height: 300px">
                        <button
                            class="btn btn-primary import-tree-trigger"
                        >Importer</button>
                        <div class="import-tree-container" class="w-full h-full"></div>
                        <textarea class="import-tree-value" style="width: 100%; height: 100%"></textarea>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection
