@props([
    'label' => null,
    'options' => [],         // [ ['value'=>1,'label'=>'Male'], ... ]
    'multiple' => false,
    'checkbox' => false,
    'placeholder' => 'Select...',
    'search' => false,
    'name' => 'select',
    'selected' => [],
    'class' => '',
])

<div x-data="selectComponent({
        options: @js($options),
        selected: @js($selected),
        multiple: @js($multiple),
        checkbox: @js($checkbox),
        placeholder: '{{ $placeholder }}',
        name: '{{ $name }}',
        search: @js($search)
    })"
    class="w-full {{ $class }}">

    {{-- Label --}}
    @if($label)
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
        </label>
    @endif

    {{-- Select box --}}
    <div @click="toggleDropdown"
         class="border rounded-xl px-4 py-2 flex items-center justify-between cursor-pointer bg-white">
        <span x-text="displayText()" class="text-gray-700"></span>
        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-500"></i>
    </div>

    {{-- Dropdown --}}
    <div x-show="open"
         x-transition
         @click.away="open=false"
         class="border rounded-xl bg-white mt-2 shadow-lg max-h-60 overflow-y-auto p-2 z-50">

        {{-- Search --}}
        <template x-if="searchEnabled">
            <input type="text"
                   x-model="search"
                   class="w-full mb-2 p-2 border rounded"
                   placeholder="Search..." />
        </template>

        {{-- Options --}}
        <template x-for="item in filteredOptions()" :key="item.value">
            <div class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 cursor-pointer"
                 @click="select(item.value)">

                <template x-if="checkbox">
                    <input type="checkbox"
                           :checked="selected.includes(item.value)"
                           class="w-4 h-4">
                </template>

                <span x-text="item.label"></span>
            </div>
        </template>
    </div>

    {{-- Hidden inputs --}}
    <template x-if="!multiple">
        <input type="hidden" :name="name" :value="selected[0] ?? ''">
    </template>

    <template x-if="multiple">
        <template x-for="v in selected" :key="v">
            <input type="hidden" :name="name + '[]'" :value="v">
        </template>
    </template>
</div>

<script>
function selectComponent(config) {
    return {
        open: false,
        options: config.options,
        selected: Array.isArray(config.selected) ? config.selected : [config.selected],
        multiple: config.multiple,
        checkbox: config.checkbox,
        placeholder: config.placeholder,
        name: config.name,
        searchEnabled: config.search,
        search: '',

        toggleDropdown() {
            this.open = !this.open;
        },

        filteredOptions() {
            if (!this.search) return this.options;
            return this.options.filter(o =>
                o.label.toLowerCase().includes(this.search.toLowerCase())
            );
        },

        select(value) {
            if (this.multiple) {
                this.selected.includes(value)
                    ? this.selected = this.selected.filter(v => v !== value)
                    : this.selected.push(value);
            } else {
                this.selected = [value];
                this.open = false;
            }
        },

        displayText() {
            if (!this.selected.length) return this.placeholder;
            const labels = this.options
                .filter(o => this.selected.includes(o.value))
                .map(o => o.label);
            return this.multiple ? labels.join(', ') : labels[0];
        }
    }
}
</script>
