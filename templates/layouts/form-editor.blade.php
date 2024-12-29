@extends('layouts-new.common.blank')
@section('page-title')
    Mon bureau
@endsection

@section('body')

{{-- 2 column div with tailwind --}}
<div x-data="application" class="skill-tree-editor no-pcl-style">


    {{-- <div id="my-wysiwyg-editor"></div>
    <button id="save-button" class="btn btn-primary">Save Content</button>

    <button id="open-media-library" class="btn btn-primary">Choisir un fichier</button>
    <input type="text" id="media-url" readonly />

 --}}

    <div>

        <h1 class="flex items-baseline">
            <a href="{{ get_home_url() }}/my-dektop"><i class="fas fa-home"></i></a>

            <span>Arbre de compétences</span>
            <a href="{{ $skillTree->getPermalink() }}" target="_blank">
                <i class="fas fa-external-link-alt"></i>
            </a>
        </h1>

        <div class="flex items-stretch gap-1">
            <input id="skill-tree-name" name="skill-tree-name" type="text" class="input input-bordered input-sm" placeholder=""  value="{{$skillTree->post_title}}"/>
            <button id="save-trigger" class="btn btn-primary btn-sm">Enregistrer</button>
        </div>


        <div class="grid grid-cols-12 gap-2">
            <div class="col-span-4 p-2" style="border: solid 2px #f0f; min-height: 300px">
                <div id="skill-tree"></div>

                <div>
                    <input id="skillTreeId" value="{{$skillTree->ID}}" type="hidden">
                    <input id="skillTreePermalink" value="{{$skillTree->getPermalink()}}" type="hidden">
                </div>
            </div>

            <div class="col-span-8 p-2" style="border: solid 2px #f0f; min-height: 300px">
                <template x-if="selectedNode">
                    @include($nodeInformationsTemplate)
                </template>
            </div>

            {{-- <div class="col-span-6 p-2" style="border: solid 2px #f0f; min-height: 300px">
                @include('partials.viewer')
            </div> --}}
        </div>
    </div>

</div>



<script>
    document.addEventListener('DOMContentLoaded', () => {

        console.log('%ceditor.blade.php :: 65 =============================', 'color: #f00; font-size: 1rem');
        console.log(wp);

        // Initialiser l'éditeur WYSIWYG
        wp.editor.initialize('my-wysiwyg-editor', {
            tinymce: {
                wpautop: true,
                plugins: 'link',
                toolbar1: 'bold italic underline | alignleft aligncenter alignright | link',
            },
            quicktags: true
        });
    
        // Sauvegarder le contenu
        $('#save-button').click(function () {
            const content = wp.editor.getContent('my-wysiwyg-editor');
            console.log('Contenu sauvegardé :', content);
        });

        // =========================== 
        // =========================== 

        let mediaFrame; // Variable pour stocker la fenêtre modale

        $('#open-media-library').on('click', function (e) {
            e.preventDefault();

            // Si la fenêtre modale existe déjà, réutilisez-la
            if (mediaFrame) {
                mediaFrame.open();
                return;
            }

            // Créer une nouvelle fenêtre modale pour la médiathèque
            mediaFrame = wp.media({
                title: 'Choisir un fichier',
                button: {
                    text: 'Utiliser ce fichier',
                },
                multiple: false // Permet de sélectionner un seul fichier
            });

            // Quand un fichier est sélectionné dans la médiathèque
            mediaFrame.on('select', function () {
                const attachment = mediaFrame.state().get('selection').first().toJSON();
                $('#media-url').val(attachment.url); // Met à jour l'URL dans un champ texte
                console.log('Fichier sélectionné :', attachment);
            });

            // Ouvrir la fenêtre modale
            mediaFrame.open();
        });



    });
</script>





@endsection
