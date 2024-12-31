const store = {
    mediaFrame: null,
    descriptor: {},


    descriptors: {},
    attributes: {},
    attributesErrors: {},

    currentValueIndex: 0,
    currentAttributeCode: null,
    currentParentAttributeCode: null,
    renderer: null,

    test: 2,

    loadDescriptor(descriptor) {
        this.descriptor = Object.freeze(descriptor);
        this.extractAttributes(descriptor);
    },

    loadValues(values) {
        for (let code in values) {
            if (this.attributes[code] && values[code]) {
                this.attributes[code] = values[code];
            }
        }
    },

    init() {
        this.renderer = new FieldRenderer(this);
        console.log("X-INIT");
        this.$watch("attributes", (newValue, oldValue) => {
            console.log(JSON.stringify(newValue, null, 4));
            console.log(JSON.stringify(oldValue, null, 4));
        });
    },

    extractAttributes(descriptor) {
        if (descriptor.data.code) {

            this.descriptors[descriptor.data.code] = descriptor;


            if (descriptor.data.type === 'fields-group') {
                if (!this.attributes[descriptor.data.code]) {
                    this.attributes[descriptor.data.code] = {
                        values: [],
                        errors: [],
                    };
                }
                const value = {};
                for (let child of descriptor.children) {
                    value[child.data.code] = null;
                }
                this.attributes[descriptor.data.code].values[0] = value;
            }
            else {
                this.attributes[descriptor.data.code] = {
                    values: [null],
                    errors: [],
                };
            }
        }

        for (let child of descriptor.children) {
            this.extractAttributes(child);
        }
    },

    // ===================================================

    validateVariables() {

        let valid = true;

        for (let code in this.attributes) {
            const attribute = this.attributes[code];
            const attributeDescriptor = this.descriptors[code];

            this.attributes[code].errors = [];

            if(attributeDescriptor.data.type === 'fields-group') {
                for (let valueIndex in attribute.values) {
                    this.attributes[code].errors[valueIndex] = {};
                    for(let subfieldCode in attributeDescriptor.children) {
                        const subfieldDescriptor = attributeDescriptor.children[subfieldCode];
                        this.attributes[code].errors[valueIndex][subfieldDescriptor.data.code] = false;

                        if (subfieldDescriptor.data.mandatory) {
                            if (!attribute.values[valueIndex][subfieldDescriptor.data.code]) {
                                this.attributes[code].errors[valueIndex][subfieldDescriptor.data.code] = 'Ce champ est obligatoire';
                                valid = false;
                            }
                        }

                    }
                }
            }

            if (attributeDescriptor.data.mandatory) {
                if (attribute.values.length) {
                    for (let index in attribute.values) {
                        attribute.errors[index] = false;

                        if (!attribute.values[index].length) {
                            console.log('ERROR ON ' + code + ' ' + index);
                            attribute.errors[index] = 'Ce champ est obligatoire';
                            valid = false;
                        }
                    }
                }
                else {
                    valid = false;
                }
            }
        }

        return valid;
    },

    // ===================================================

    async save() {
        if (!this.descriptor) {
            return;
        }

        if (!this.validateVariables()) {
            return;
        }

        const data = {
            action: 'save_entity',
            store: this.descriptor,
            attributes: this.attributes,
            entity_id: document.getElementById('entity_id').value,
        };

        const options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        };

        const response = await fetch('?save=1', options)
        const json = await response.json();

        if (!document.getElementById('entity_id').value) {

            // remove ?entity_id= from url
            let url = document.location.href;
            url = url.split('?')[0];
            url = url.split('#')[0];
            document.location.href = url + '?entity_id=' + json.entity.ID;
        }
    },

    // ===================================================

    resetValue(attributeCode, parentAttributeCode, index) {
        if (parentAttributeCode) {
            this.attributes[parentAttributeCode].values[index][attributeCode] = null;
        }
        else {
            this.attributes[attributeCode].values[index] = null;
        }

    },

    deleteValue(attributeCode, index) {
        this.attributes[attributeCode].values.splice(index, 1);
    },

    setValue(attributeCode, parentField, index, value,) {
        if (parentField) {

            if(!this.attributes[parentField]) {
                console.error('No values for attribute ' + parentField);
            }

            if(!this.attributes[parentField].values) {
                console.error('No values for attribute ' + parentField + '[' + index + ']');
            }
            this.attributes[parentField].values[index][attributeCode] = value;
            return this.attributes[parentField].values[index][attributeCode];
        }
        this.attributes[attributeCode].values[index] = value;

        return this.attributes[attributeCode].values[index];
    },

    getModel(attributeCode, parentField, index) {

        console.log('%cStore.js :: 161 =============================', 'color: #f00; font-size: 1rem');
        console.log(attributeCode);
        console.log(parentField);
        console.log(index);

        if (parentField) {
            return `attributes['${parentField}'].values[${index}]['${attributeCode}']`;
        }
        return `attributes['${attributeCode}'].values[${index}]`;
    },

    getValue(attributeCode, parentField, index) {
        if (parentField) {
            return this.attributes[parentField].values[index][attributeCode];
        }
        return this.attributes[attributeCode].values[index];
    },

    // ===================================================

    initializeWysiwygEditor(attributeCode, parentField, valueIndex, textareaId) {
        const attribute = this.attributes[attributeCode];
        const self = this;

        const node = document.getElementById(textareaId);
        const tinyMceInstance = tinymce.get(textareaId);

        if (tinyMceInstance) {
            tinyMceInstance.remove();
        }

        wp.editor.initialize(textareaId, {
            tinymce: {
                wpautop: true,
                plugins: 'link',
                // all options for toolbar1
                toolbar1: 'formatselect,media_button,bold,italic,underline,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink',
                setup: (editor) => {
                    editor.on('input', function () {
                        const newValue = self.setValue(
                            attributeCode,
                            parentField,
                            valueIndex, editor.getContent()
                        );
                    });
                    editor.on('change', function () {
                        const newValue = self.setValue(
                            attributeCode,
                            parentField,
                            valueIndex, editor.getContent()
                        );
                    });

                    // Ajout du bouton Médiathèque
                    editor.addButton('media_button', {
                        icon: false,
                        text: '🖼️',
                        tooltip: 'Ajouter une image depuis la médiathèque',
                        onclick: () => {
                            // Ouvrir la médiathèque
                            if (!this.mediaFrame) {
                                this.initializeMediaLibrary();
                            }

                            // Configuration pour la sélection de l'image
                            this.currentAttributeCode = attribute;
                            this.currentValueIndex = valueIndex;

                            this.mediaFrame.off('select'); // Éviter les doublons d'événements
                            this.mediaFrame.on('select', () => {
                                const attachment = this.mediaFrame.state().get('selection').first().toJSON();
                                const imgHTML = `<img src="${attachment.url}" alt="${attachment.alt}" />`;
                                editor.insertContent(imgHTML);
                                // seems to not be working
                                // attribute.values[index] = attachment.url;
                            });

                            // Ouvrir la médiathèque
                            this.mediaFrame.open();
                        }
                    });
                }
            },
            quicktags: true
        });
    },

    previewImage() {
        return 'hello world';
    },

    // ===================================================

    initializeMediaLibrary() {
        this.mediaFrame = wp.media({
            title: 'Choisir un fichier',
            button: {
                text: 'Utiliser ce fichier',
            },
            multiple: false,
        });

        this.mediaFrame.on('select', () => {
            const attachment = this.mediaFrame.state().get('selection').first().toJSON();

            this.setValue(
                this.currentAttributeCode,
                this.currentParentAttributeCode,
                this.currentValueIndex,
                attachment.url,
            );
        });
    },

    // ===================================================

    openMediaLibrary(attributeCode, parentAttributeCode, index) {
        this.currentAttributeCode = attributeCode;
        this.currentParentAttributeCode = parentAttributeCode;
        this.currentValueIndex = index;

        // JDLX_TODO  monkey patch, images are not displayed at first load
        setTimeout(() => {
            const mediaButton = document.querySelector('#menu-item-browse');
            if (mediaButton) {
                mediaButton.click();
            }
            const uploadButton = document.querySelector('#menu-item-upload');
            if (uploadButton) {
                uploadButton.click();
            }
        }, 100);



        this.mediaFrame.open();
    },

    loadMap(attributeCode, parentAttributeCode, index, id) {

        let value = '';

        if (parentAttributeCode) {
            value = this.attributes[parentAttributeCode].values[index][attributeCode];
        }
        else {
            value = this.attributes[attributeCode].values[index];
        }


        const mapContainerId = 'map-container-' + id;

        if (!value || !value.lat || !value.lon) {
            return;
        }

        const mapContainer = document.getElementById(mapContainerId);
        if (!mapContainer) {
            console.error('No map container');
            return;
        }

        if (mapContainer.map) {
            mapContainer.map.remove();
        }

        mapContainer.map = L.map(mapContainer, {
            scrollWheelZoom: false,
        });


        mapContainer.map.setView([value.lat, value.lon], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(mapContainer.map);

        // L.marker([data[0].lat, data[0].lon]).addTo(map);

        let circle = L.circle([value.lat, value.lon], {
            color: 'green',
            fillColor: '#8f8',
            fillOpacity: 0.5,
            radius: 500
        }).addTo(mapContainer.map);

        setTimeout(() => {
            mapContainer.map.invalidateSize();
        }, 100);
    },

    async searchMap(attributeCode, parentAttributeCode, index, id, search,) {

        const url = `https://nominatim.openstreetmap.org/search?q=${search}&limit=5&format=json&addressdetails=1`;
        const response = await fetch(url);
        const data = await response.json();

        if (data.length) {
            this.setValue(
                attributeCode,
                parentAttributeCode,
                index,
                {
                    lat: data[0].lat,
                    lon: data[0].lon,
                    caption: search,
                }
            );

            this.loadMap(attributeCode, parentAttributeCode, index, id);
        }
        return;
    },

    setRating(attributeCode, parentAttributeCode, index, value) {
        this.setValue(attributeCode, parentAttributeCode, index, value);
    },

    renderYoutubeVideo(url) {
        if (!url) {
            return '';
        }

        const videoId = url.replace('https://www.youtube.com/watch?v=', '');
        return `
          <iframe
              src="https://www.youtube.com/embed/${videoId}"
              title="YouTube video player"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
              class="attribute-value--youtube-iframe"
          ></iframe>
      `;
    },


    getAttributeContainerCssClass(attribute) {
        let cssClass = ''
        if (attribute.data.type === 'fields-group') {
            cssClass = 'col-span-12';
        }
        else if (attribute.data.width) {
            cssClass = 'col-span-' + attribute.data.width;
        }
        else {
            cssClass = 'col-span-12';
        }

        return cssClass;
    },

    // ===================================================

    repeatField(attributeCode) {

        const attributeDescriptor = this.descriptors[attributeCode];

        if(!attributeDescriptor) {
            console.error('No descriptor for ' + attributeCode);
            console.log(this.descriptors);
            return;
        }

        if (attributeDescriptor.data.type === 'fields-group') {
            const value = {};
            for (let child of attributeDescriptor.children) {
                value[child.data.code] = null;
            }
            this.attributes[attributeCode].values.push(value);
        }
        else {
            this.attributes[attributeCode].values.push(null);
        }
    },

    // ===================================================

    renderFieldset(attribute, parentField, index) {
        let content = '';

        content += `
          <div x-show="${(index > 0 && !parentField) ? 'true' : 'false'}"class="fieldset-header">
              <button
                  x-on:click="deleteValue(
                      '${attribute.data.code}',
                      '${index}',
                  )"
                  class="btn ri-delete-bin-fill"
              ></button>
          </div>
      `;

        content += '<fieldset>';
            content += '<div class="flex gap-4 items-center">';
                content += this.renderer.renderField(attribute, parentField, index)
            content += '</div>';

        // content += `
        //     <div role="alert" class="alert alert-error p-1 mt-1 " x-show="attributesErrors[attribute.data.code][index]">
        //         <svg
        //             xmlns="http://www.w3.org/2000/svg"
        //             class="h-6 w-6 shrink-0 stroke-current"
        //             fill="none"
        //             viewBox="0 0 24 24">
        //             <path
        //             stroke-linecap="round"
        //             stroke-linejoin="round"
        //             stroke-width="2"
        //             d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        //         </svg>
        //         <span x-html="attributesErrors[attribute.data.code][index]"></span>
        //     </div>
        // `;

        content += `
          </fieldset>
       `;



        const template = attribute.data.template ?? '';
        if (template) {
            content = template.replace('${CONTENT}', content);
        }

        return content;
    },

    // ===================================================
};
