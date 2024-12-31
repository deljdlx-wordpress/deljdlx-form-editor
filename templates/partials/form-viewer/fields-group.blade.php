
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
                <div>
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

                    {{-- <pre x-html="JSON.stringify(attributes[attributeDescriptor.data.code].errors, null, 4)"></pre> --}}


                    <template x-if="attributes[attributeDescriptor.data.code].errors[subValueIndex]">
                        <div
                            role="alert"
                            class="alert alert-error p-1 mt-1 "
                            x-show="attributes[attributeDescriptor.data.code].errors[subValueIndex][subfieldDescriptor.data.code]"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 shrink-0 stroke-current"
                                fill="none"
                                viewBox="0 0 24 24">
                                <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span x-html="attributes[attributeDescriptor.data.code].errors[subValueIndex][subfieldDescriptor.data.code]"></span>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>
</template>
