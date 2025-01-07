<template x-if="selectedNode.id !== 'root'">
    <form id="skill-editor">
        {{-- <textarea style="width: 100%; height: 400px;" x-model="JSON.stringify(selectedNode, null , 4)"></textarea> --}}
            <fieldset>
                <label class="flex items-center gap-2">
                    <span class="label-text">Nom :</span>
                    <input x-on:input="updateSelectedNode" x-model="selectedNode.text" name="name" type="text" class="grow outline-none" placeholder="" />
                </label>
            </fieldset>

            <fieldset>
                <label class="flex items-center gap-2">
                    <span class="label-text">Code :</span>
                    <input x-on:input="updateSelectedNode" x-model="selectedNode.data.code" name="code" type="text" class="grow outline-none" placeholder="" />
                </label>
            </fieldset>

            <fieldset>
                <label class="flex items-center gap-2">
                    <span class="label-text">ACF mapping :</span>
                    <input x-on:input="updateSelectedNode" x-model="selectedNode.data.acfMapping" name="acf_mapping" type="text" class="grow outline-none" placeholder="" />
                </label>
            </fieldset>

            <fieldset>
                <label>
                    <span class="label-text">Type de champs</span>
                    <select class="w-full max-w-xs outline-none" x-model="selectedNode.data.type">
                        <option disabled selected>Type de champs</option>
                        <option value="text">Texte</option>
                        <option value="wysiwyg">Texte riche</option>
                        <option value="number">Nombre</option>
                        <option value="rating">Rating</option>
                        <option value="image">Image</option>
                        <option value="file">Fichier</option>


                        <option value="select">Select</option>
                        <option value="toggle">Toggle</option>


                        <option value="video">Video</option>
                        <option value="map">Map</option>
                        <option value="fields-group">Fields group</option>
                    </select>
                </label>
            </fieldset>

            <fieldset>
                <label class="flex items-center gap-2">
                    <span class="label-text">Largeur</span>
                    <select class="w-full max-w-xs outline-none" x-model="selectedNode.data.width">
                        <option disabled selected>Largeur du champ</option>
                        <option value="12">12/12</option>
                        <option value="8">8/12</option>
                        <option value="6">6/12</option>
                        <option value="4">4/12</option>
                        <option value="3">3/12</option>
                        <option value="2">2/12</option>
                        <option value="1">1/12</option>
                    </select>
                </label>
            </fieldset>


            <template x-if="selectedNode.data.type === 'select'">
                <div x-init="if(!selectedNode.data.options) {
                    selectedNode.data.options = [];
                }">
                    <label class="flex items-center gap-2">Options</label>
                    <ul>
                        <template x-for="(option, optionIndex) in selectedNode.data.options">
                            <li class="flex items-center">
                                <label class="input input-bordered flex items-center gap-2">
                                    Label :
                                    <input x-model="option.caption" type="text" class="grow outline-none" placeholder="" />
                                </label>

                                <label class="input input-bordered flex items-center gap-2">
                                    Valeur :
                                    <input x-model="option.value" type="text" class="grow outline-none" placeholder="" />
                                </label>
                                <button x-on:click="
                                    selectedNode.data.options.splice(optionIndex, 1)
                                " class="btn ri-delete-bin-fill"></button>
                            </li>

                        </template>
                    </ul>

                    <span x-on:click="selectedNode.data.options.push({caption: '', value: ''})" class="btn ri-add-circle-line"></span>

                </div>
            </template>


            <template x-if="selectedNode.data.type === 'fields-group'">
                <fieldset>
                    <label class="flex items-center gap-2">
                        <span class="label-text">Largeur des sous groupe</span>
                        <select class="w-full max-w-xs outline-none" x-model="selectedNode.data.subfieldsWidth">
                            <option disabled selected>Largeur du champ</option>
                            <option value="12">12/12</option>
                            <option value="8">8/12</option>
                            <option value="6">6/12</option>
                            <option value="4">4/12</option>
                            <option value="3">3/12</option>
                            <option value="2">2/12</option>
                            <option value="1">1/12</option>
                        </select>
                    </label>
                </fieldset>
            </template>



            <fieldset>
                <div class="form-control" style="width: 150px">
                    <label class="flex items-center gap-2">
                      <span class="label-text">Champ obligatoire</span>
                      <input type="checkbox" class="checkbox" x-model="selectedNode.data.mandatory" :checked="selectedNode.data.mandatory ?? false"/>
                    </label>
                </div>
            </fieldset>

            <fieldset>
                <div class="form-control" style="width: 150px">
                    <label class="flex items-center gap-2">
                      <span class="label-text">Lecture seule</span>
                      <input type="checkbox" class="checkbox" x-model="selectedNode.data.readonly" :checked="selectedNode.data.readonly ?? false"/>
                    </label>
                </div>
            </fieldset>

            <fieldset>
                <div class="form-control" style="width: 150px">
                    <label class="flex items-center gap-2">
                      <span class="label-text">Champ répétable</span>
                      <input type="checkbox" class="checkbox" x-model="selectedNode.data.repeat" :checked="selectedNode.data.repeat ?? false"/>
                    </label>
                </div>
            </fieldset>


            <fieldset>
                <label class="flex items-center gap-2">
                    <span class="label-text">Description :</span>
                </label>
                <div class="wysiwyg-wrapper">
                    <textarea x-on:input="updateSelectedNode" x-model="selectedNode.data.description" name="description" class="wysiwyg textarea textarea-bordered w-full grow outline-none"></textarea>
                <div>
            </fieldset>


            <fieldset>
                <label>
                    Template (Use ${CONTENT} to insert the value of the field in the template): 
                </label>
                <div>
                    {{-- <textarea x-on:input="updateSelectedNode" x-model="selectedNode.data.value" name="value" class="textarea textarea-bordered w-full grow"></textarea> --}}
                    <div class="code" data-field-name="template" data-lines="15"></div>
                <div>
            </fieldset>




            {{-- <template x-if="selectedNode.type === 'attribute'">

            </template> --}}

            {{-- <template x-if="selectedNode.type === 'cluster' || selectedNode.type === 'skill' || selectedNode.type === 'perk'"> --}}

            <fieldset>
                <label>
                    Valeur :
                </label>
                <div>
                    {{-- <textarea x-on:input="updateSelectedNode" x-model="selectedNode.data.value" name="value" class="textarea textarea-bordered w-full grow"></textarea> --}}
                    <div class="code" data-field-name="value" data-lines="1"></div>
                <div>
            </fieldset>

    </form>
</template>