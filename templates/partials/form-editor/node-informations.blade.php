<template x-if="selectedNode.id !== 'root'">
    <form id="skill-editor">
        <h2>Informations</h2>
        {{-- <textarea style="width: 100%; height: 400px;" x-model="JSON.stringify(selectedNode, null , 4)"></textarea> --}}
            <fieldset>
                <label class="input input-bordered flex items-center gap-2">
                    Nom :
                    <input x-on:input="updateSelectedNode" x-model="selectedNode.text" name="name" type="text" class="grow" placeholder="" />
                </label>
            </fieldset>

            <fieldset>
                <label class="input input-bordered flex items-center gap-2">
                    Code :
                    <input x-on:input="updateSelectedNode" x-model="selectedNode.data.code" name="code" type="text" class="grow" placeholder="" />
                </label>
            </fieldset>

            <fieldset>
                <label>Type de champs</label>
                <select class="select select-bordered w-full max-w-xs" x-model="selectedNode.data.type">
                    <option disabled selected>Type de champs</option>
                    <option value="text">Texte</option>
                    <option value="wysiwyg">Texte riche</option>
                    <option value="number">Nombre</option>
                    <option value="image">Image</option>
                    <option value="rating">Rating</option>
                    <option value="file">Fichier</option>
                    <option value="video">Video</option>
                    <option value="map">Map</option>
                    <option value="fields-group">Fields group</option>
                </select>
            </fieldset>

            <fieldset>
                <label>Largeur</label>
                <select class="select select-bordered w-full max-w-xs" x-model="selectedNode.data.width">
                    <option disabled selected>Largeur du champ</option>
                    <option value="12">12/12</option>
                    <option value="8">8/12</option>
                    <option value="6">6/12</option>
                    <option value="4">4/12</option>
                    <option value="3">3/12</option>
                    <option value="2">2/12</option>
                    <option value="1">1/12</option>
                </select>
            </fieldset>



            <fieldset>
                <div class="form-control" style="width: 150px">
                    <label class="label cursor-pointer">
                      <span class="label-text">Champ obligatoire</span>
                      <input type="checkbox" class="checkbox" x-model="selectedNode.data.mandatory" :checked="selectedNode.data.mandatory ?? false"/>
                    </label>
                </div>
            </fieldset>

            <fieldset>
                <div class="form-control" style="width: 150px">
                    <label class="label cursor-pointer">
                      <span class="label-text">Lecture seule</span>
                      <input type="checkbox" class="checkbox" x-model="selectedNode.data.readonly" :checked="selectedNode.data.readonly ?? false"/>
                    </label>
                </div>
            </fieldset>

            <fieldset>
                <div class="form-control" style="width: 150px">
                    <label class="label cursor-pointer">
                      <span class="label-text">Champ répétable</span>
                      <input type="checkbox" class="checkbox" x-model="selectedNode.data.repeat" :checked="selectedNode.data.repeat ?? false"/>
                    </label>
                </div>
            </fieldset>


            <fieldset>
                <label>
                    Description :
                </label>
                <div class="wysiwyg-wrapper">
                    <textarea x-on:input="updateSelectedNode" x-model="selectedNode.data.description" name="description" class="wysiwyg textarea textarea-bordered w-full grow"></textarea>
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