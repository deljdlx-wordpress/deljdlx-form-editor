class FieldRenderer
{

  store = null;

  constructor(store) {
    this.store = store;
    this.attributes = store.attributes;
  }

  renderField(attributeDescriptor, parentField, index, model) {
    let content = '';

    switch(attributeDescriptor.data.type) {
      case 'text':
          content += this.renderText(attributeDescriptor, parentField, index, model);
          break;
      case 'number':
          content += this.renderNumber(attributeDescriptor, parentField, index, model);
          break;
      case 'rating':
          content += this.renderRating(attributeDescriptor, parentField, index, model);
            break;
      case 'wysiwyg':
          content += this.renderWysiwyg(attributeDescriptor, parentField, index, model);
          break;
      case 'image':
          content += this.renderImage(attributeDescriptor, parentField, index, model);
          break;
      case 'video':
          content += this.renderVideo(attributeDescriptor, parentField, index, model);
          break;
      case 'map':
          content += this.renderMap(attributeDescriptor, parentField, index, model);
          break;
      // case 'fields-group':
      //     content += this.renderFieldsGroup(attributeDescriptor, parentField, index, model);
      //     break;
      default:
          content += this.renderText(attributeDescriptor, parentField, index, model);
    }

    return content;
  }

  generateId(attributeDescriptor, parentField, index) {
    const id = (parentField ? parentField + '_' : '') + attributeDescriptor.data.code + '_' + index;
    return id;
  }



  renderText(attributeDescriptor, parentField, index) {

    const id = this.generateId(attributeDescriptor, parentField, index);

    let disabled = '';
    if(attributeDescriptor.data.readonly) {
        disabled = 'disabled="disabled"';
    }

    let model = this.store.getModel(attributeDescriptor.data.code, parentField, index);

    console.log('%cFieldRenderer.js :: 64 =============================', 'color: #f00; font-size: 1rem');
    console.log(model);

    //const disabled = (attributeDescriptor.data.readonly ?? false) ? 'disabled' : '';


    return `
        <input
            id="${id}"
            x-model="${model}"
            type="text"
            placeholder="Type here"
            class="input input-bordered input-primary w-full grow"
            ${disabled}"
        />
    `;
  }

  renderNumber(attributeDescriptor, parentField, index) {
    const id = this.generateId(attributeDescriptor, parentField, index);
    const disabled = (attributeDescriptor.data.readonly ?? false) ? 'disabled="true"' : '';
    let model = this.store.getModel(attributeDescriptor.data.code, parentField, index);


    return `
        <input
            id="${id}"
            x-model="${model}"
            type="number"
            placeholder="Type here"
            class="input input-bordered input-primary w-full grow"
            ${disabled}"
        />
    `;
  }

  renderRating(attributeDescriptor, parentField, index) {
    const id = this.generateId(attributeDescriptor, parentField, index);
    let model = this.store.getModel(attributeDescriptor.data.code, parentField, index);


    let content = ``;
    content += `
          <input
          id="${id}"
          x-model="${model}"
          type="text"
          placeholder="Type here"
          class="input input-bordered input-primary w-full grow"
      />
      `;

      const value = this.store.getValue(attributeDescriptor.data.code, parentField, index);

      content += `<div x-html="${model}"></div>`;


      content += `<div class="rating">`;
        for(let i = 1; i <= 5; i++) {
            let checked =  '';

            if(i == value) {
                checked = 'checked="checked"';
            }
            content += `<input
              ${checked}
              type="radio"
              name="${attributeDescriptor.data.code + '_' + parentField + '_' + index}"
              class="mask mask-star-2"
              @click="setRating('${attributeDescriptor.data.code}', '${parentField}', '${index}', ${i})"
            />`;
        }
        content += `</div>`;

    return content;
  }


  renderWysiwyg(attributeDescriptor, parentField, index) {
    const id = this.generateId(attributeDescriptor, parentField, index);
    let model = this.store.getModel(attributeDescriptor.data.code, parentField, index);

    let content = ``;
    content += `
        <textarea
            id="${id}"
            x-model="${model}"
            class="wysiwyg"
            :x-init="setTimeout(() => {
                console.log('INIT WYSIWYG: ${id}');
                initializeWysiwygEditor(
                    '${attributeDescriptor.data.code}',
                    ${(parentField ? "'" + parentField + "'" : 'null')},
                    '${index}',
                    '${id}',
                );
            }, 200)"
        ></textarea>
    `;

    return content;
  }

  renderImage(attributeDescriptor, parentField, index) {

    const attribute = this.attributes[attributeDescriptor.data.code];
    const id = this.generateId(attributeDescriptor, parentField, index);

    let value = '';
    if(parentField) {
        value = this.attributes[parentField].values[index][attributeDescriptor.data.code];
    }
    else {
        value = attribute.values[index];
    }


    let content =  `
        <div id="${id}" class="" style="width:100%">
    `;
        content +=  `
            <div class="attribute-image-container grow">
        `;
            if(attribute.values[index]) {
                content += `<button
                        x-on:click="resetValue(
                          '${attributeDescriptor.data.code}',
                          ${parentField ? "'" + parentField + "'" : 'null'},
                          '${index}'
                        )"
                        class="
                            ri-eraser-line
                            attribute-button-reset-value
                            attribute-button-reset-value--image
                        ">
                    </button>
                `;
            }

            if(value) {
                content += `
                    <img
                        src="${value}"
                        class="attribute-value--image"
                    >
                `;
            }
        content += `</div>`;
        content += `
            <div>
                <button
                    class="
                        btn btn-primary
                        button-choose-image
                    "
                    x-on:click="openMediaLibrary(
                        '${attributeDescriptor.data.code}',
                        ${parentField ? "'" + parentField + "'" : 'null'},
                        '${index}',
                    )"
                >
                    Choisir un fichier
                </button>
            </div>
        `;
    content += `</div>`;

    return content;
  }

  renderVideo(attributeDescriptor, parentField, index) {

    const attribute = this.attributes[attributeDescriptor.data.code];
    const id = this.generateId(attributeDescriptor, parentField, index);
    const model = this.store.getModel(attributeDescriptor.data.code, parentField, index);

    const value = this.store.getValue(attributeDescriptor.data.code, parentField, index);

    let content = `<div class="grow w-full">`;
        content +=  `<div class="flex">`
            if(value) {
                content += `
                    <button
                        x-on:click="resetValue(
                            '${attributeDescriptor.data.code}',
                            ${parentField ? "'" + parentField + "'" : 'null'},
                            '${index}',
                        )"
                        class="
                            ri-eraser-line
                            attribute-button-reset-value
                            attribute-button-reset-value--video
                        ">
                    </button>
                `;
            }

            content += `
                <input
                    id="${id}"
                    x-model="${model}"
                    type="text"
                    placeholder="Type here"
                    class="input input-bordered input-primary w-full"/>
            `;
        content += `</div>`;



        if(value) {
            content += `
                <div class="w-full"
                    x-html="renderYoutubeVideo('${value}')">
                </div>
            `;
        }
    content += `</div>`;

    return content;
  }

  renderMap(attributeDescriptor, parentField, index) {


    // let value = {
    //   lat: null,
    //   lon: null,
    //   caption: '',
    // } ;

    let value = this.store.getValue(attributeDescriptor.data.code, parentField, index);



    const id = this.generateId(attributeDescriptor, parentField, index);

    let content = `
        <div class="grow w-full">
            <input
                id="${id}"
                value="${value.caption}"
                @keyup.enter="searchMap(
                    '${attributeDescriptor.data.code}',
                    '${parentField ? parentField : ''}',
                    '${index}',
                    '${id}',
                    $event.target.value,
                )"
                type="text"
                placeholder="Type here"
                class="input input-bordered input-primary w-full"/>
            <div
                id="map-container-${id}"
                x-init="loadMap(
                    '${attributeDescriptor.data.code}',
                    '${parentField ? parentField : ''}',
                    '${index}',
                    '${id}',
                )"
                class="
                    w-full
                    map-container
                    attribute-value--map-container
                "
            >
            </div>
        </div>
    `;

    return content;
  }

  renderFieldsGroup(attributeDescriptor, parentField, index, model) {
    let content = `
        <div class="fields-group-container">
    `;

        for(let childIndex in attributeDescriptor.children) {
            const childAttribute = attributeDescriptor.children[childIndex];
            const model = `attributes['${attributeDescriptor.data.code}'].values[${index}]['${childAttribute.data.code}']`;

            content += `
                <div
                  class="
                    subfield-container
                    subfield-container--${childAttribute.data.type}
                    subfield-container--${childAttribute.data.code}
                ">
            `;
                content += `<h4 class="subfield-name">${childAttribute.text}</h4>`;

                // content += this.renderAttribute(
                //     childAttribute,
                //     childIndex,
                //     // model,
                //     // attributeDescriptor.data.code,
                // );

                content += this.store.renderFieldset(
                    childAttribute,
                    index,
                    model,
                    attributeDescriptor.data.code,
                );

            content += `
                </div>
            `;
        }


    content += '</div>';

    return content;
  }

}



