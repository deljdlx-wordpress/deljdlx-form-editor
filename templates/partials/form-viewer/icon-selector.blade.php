<div id="icon-selector" class="hidden">
    <div class="flex gap-1">
        <select
            x-model="selectedIconPanel"
            :change="selectIconPanel()";
            class="grow"
        >
            <template x-for="(iconCategory, index) in icons">
                <option :value="index" x-text="iconCategory.title"></option>
            </template>
        </select>
        {{-- hidde button --}}
        <i class="ri-close-circle-fill" x-on:click="hideIconSelector()"></i>
    </div>

    <template x-for="(iconCategory, index) in icons">
        <div
            :id="'icon-tab-'+index"
            class="icon-list icon-panel hidden"
            x-init="if(index === 0) { $el.classList.remove('hidden') }"
        >
            <div class="flex flex-wrap gap-0.5">
                <template x-for="(icon, iconIndex) in iconCategory.icons">
                    <i :class="icon.className + ' icon'" x-on:click="selectIcon(icon.className)"></i>
                </template>
            </div>
        </div>
    </template>
</div>