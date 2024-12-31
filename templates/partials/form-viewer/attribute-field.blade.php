<template x-for="(value, valueIndex) in attributes[attributeDescriptor.data.code].values">
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
        <div>
            <fieldset>
                <div class="flex gap-4 items-center">
                    <div class="w-full" x-html="renderFieldset(attributeDescriptor, null, valueIndex)"></div>
                </div>
            </fieldset>

            <div
                role="alert"
                class="alert alert-error p-1 mt-1 "
                x-show="attributes[attributeDescriptor.data.code].errors[valueIndex]"
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
                <span x-html="attributes[attributeDescriptor.data.code].errors[valueIndex]"></span>
            </div>

        </div>
    </div>
</template>