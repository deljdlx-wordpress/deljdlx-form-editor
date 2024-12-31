
<template x-for="(subValue, subValueIndex) in attributes[attributeDescriptor.data.code].values">
    <div
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
    >

        {{-- Delete fields group part --}}
        <div x-show="subValueIndex > 0"class="fieldset-header">
            <button
                x-on:click="deleteValue(
                    attributeDescriptor.data.code,
                    subValueIndex,
                )"
                class="btn ri-delete-bin-fill"
            ></button>
        </div>


        <div class="fields-group-container">
            <template x-for="(subfieldDescriptor, subfieldIndex) in attributeDescriptor.children">
                <fieldset>
                    <div class="flex gap-4 items-center">
                        <div
                            class="subfield-container w-full"
                            :class="
                                'subfield-container--' + subfieldDescriptor.data.type +
                                ' subfield-container--' + subfieldDescriptor.data.code
                            "
                        >
                            <h4 class="subfield-name" x-html="subfieldDescriptor.text"></h4>
                            <div x-html="renderFieldset(
                                subfieldDescriptor,
                                attributeDescriptor.data.code,
                                subValueIndex
                            )"></div>
                        </div>
                    </div>
                </fieldset>
            </template>
        </div>
    </div>
</template>
