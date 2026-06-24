@props(['name', 'options', 'selected' => null, 'placeholder' => 'Pilih...', 'class' => '', 'variant' => 'default', 'icon' => null, 'formId' => null])

<div x-data="{ 
    open: false, 
    selected: '{{ $selected ?? '' }}',
    options: {{ json_encode($options) }},
    get selectedLabel() {
        const opt = this.options.find(o => o.value === this.selected);
        return opt ? opt.label : '{{ $placeholder }}';
    },
    select(val) {
        this.selected = val;
        this.open = false;
        @if($formId)
        this.$nextTick(() => document.getElementById('{{ $formId }}').submit());
        @endif
    }
}" class="relative {{ $class }}" x-cloak>
    @if($variant === 'pill')
    <button 
        type="button"
        @click="open = !open"
        @click.away="open = false"
        class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full transition-all duration-200 cursor-pointer"
        :class="selected ? 'bg-[#013D29] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
    >
        @if($icon)
            <span class="text-current">{!! $icon !!}</span>
        @endif
        <span x-text="selectedLabel"></span>
        <svg class="w-3.5 h-3.5 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        class="absolute left-0 z-50 mt-2 min-w-[180px] bg-white border border-gray-100 rounded-xl shadow-xl py-1.5 overflow-hidden">
        <template x-for="option in options" :key="option.value">
            <button
                type="button"
                @click="select(option.value)"
                class="w-full px-4 py-2.5 text-left text-sm hover:bg-gray-50 transition-colors flex items-center justify-between gap-3"
                :class="{ 'text-[#013D29] font-medium bg-emerald-50/50': selected === option.value, 'text-gray-600': selected !== option.value }"
                x-text="option.label">
            </button>
        </template>
    </div>
    @else
    <button 
        type="button"
        @click="open = !open"
        @click.away="open = false"
        class="w-full flex items-center justify-between px-4 py-2.5 bg-white border border-gray-300 rounded-lg hover:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
        <span class="text-gray-700 truncate" x-text="selectedLabel"></span>
        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    
    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden">
        <template x-for="option in options" :key="option.value">
            <button
                type="button"
                @click="selected = option.value; open = false; $dispatch('input', option.value)"
                class="w-full px-4 py-2.5 text-left hover:bg-brand-50 hover:text-brand-700 transition-colors"
                :class="{ 'bg-brand-50 text-brand-700 font-medium': selected === option.value }"
                x-text="option.label">
            </button>
        </template>
    </div>
    @endif
    
    <input type="hidden" :name="'{{ $name }}'" :value="selected">
</div>
