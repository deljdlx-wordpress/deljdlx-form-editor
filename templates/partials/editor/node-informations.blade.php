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
                <label>
                    Illustration :
                </label>
                <input id="imageUploader" x-on:input="updateSelectedNode" name="image" type="file" class="grow" placeholder="" />
                <div id="imagePreview" style="display: none"></div>
            </fieldset>


            <template x-if="selectedNode.data.illustration">
                <fieldset>
                    <img :src="selectedNode.data.illustration"/>
                </fieldset>
            </template>


            <fieldset>
                <label>
                    Description :
                </label>
                <div>
                    <textarea x-on:input="updateSelectedNode" x-model="selectedNode.data.description" name="description" class="quill textarea textarea-bordered w-full grow"></textarea>
                <div>
            </fieldset>

            <fieldset>
                <label class="input input-bordered flex items-center gap-2">
                    Code :
                    <input x-on:input="updateSelectedNode" x-model="selectedNode.data.code" name="code" type="text" class="grow" placeholder="" />
                </label>
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

            <fieldset>
                <label>
                    Modificateurs :
                </label>
                <div>
                    {{-- <textarea x-on:input="updateSelectedNode" x-model="selectedNode.data.modifiers" name="modifiers" class="textarea textarea-bordered w-full grow"></textarea> --}}
                    <div class="code" data-field-name="modifiers" data-lines="10"></div>
                <div>
            </fieldset>
    </form>
</template>