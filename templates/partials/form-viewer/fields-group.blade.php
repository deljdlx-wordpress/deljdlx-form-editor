
<template x-for="(subValue, subValueIndex) in attributes[attributeDescriptor.data.code].values">
    {{-- <div> --}}
    <div
        class="
            value-container
        "
        :class="
            attributeDescriptor.data.subfieldsWidth
                ? 'col-span-' + attributeDescriptor.data.subfieldsWidth
                : 'col-span-12'
        "
    >



            {{-- Delete fields group part --}}
            <button
                title="Supprimer"
                x-show="subValueIndex > 0"
                x-on:click="deleteValue(
                    attributeDescriptor.data.code,
                    subValueIndex,
                )"
                class="ri-close-circle-fill delete-value-button"
            ></button>




        <div class="fields-group-container grid grid-cols-12">
            <template x-for="(subfieldDescriptor, subfieldIndex) in attributeDescriptor.children">
                <div
                    :class="
                        subfieldDescriptor.data.width
                            ? 'col-span-' + subfieldDescriptor.data.width
                            : 'col-span-12'
                    "
                >
                    <fieldset class="flex gap-4 items-center w-full">
                        <div
                            class="subfield-container  w-full"
                        >
                            <div class="flex items-center">
                                <h4 class="subfield-name" x-html="subfieldDescriptor.text"></h4>
                            </div>

                            <template x-if="subfieldDescriptor.data.description">
                                <div class="subfield-description" x-html="subfieldDescriptor.data.description"></div>
                            </template>

                            <div x-html="renderFieldset(
                                subfieldDescriptor,
                                attributeDescriptor,
                                subValueIndex
                            )"></div>
                        </div>
                    </fieldset>

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
