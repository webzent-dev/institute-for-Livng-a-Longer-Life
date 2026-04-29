@props([
    'name',
    'label' => null,
    'id' => null,
    'value' => null,
    'required' => false,
    'placeholder' => '02:15 PM',
    'class' => '',
])

@php
    $inputId = $id ?: 'tm_' . preg_replace('/[^a-z0-9_]/i', '_', $name);
    $oldValue = old($name, $value);
@endphp

<div x-data="timePickerComponent(@js($oldValue))" class="relative w-full {{ $class }}">
    @if($label)
        <label
            for="{{ $inputId }}"
            class="mb-1 block text-sm font-medium leading-none text-slate-700 peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
        >
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif

    <div class="relative">
        <i data-lucide="clock-3" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>

        <input
            id="{{ $inputId }}"
            type="text"
            name="{{ $name }}"
            x-model="displayValue"
            @focus="open = true"
            @click="open = true"
            @blur="normalizeInput()"
            @input="onInput()"
            @keydown.escape.window="open = false"
            placeholder="{{ $placeholder }}"
            autocomplete="off"
            @if($required) required @endif
            class="flex h-11 w-full rounded-xl border border-slate-200 bg-white px-10 py-2 text-[14px] text-slate-700 placeholder:text-[14px] placeholder:text-slate-400 shadow-sm ring-offset-background transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/20"
        >

        <button
            type="button"
            @click="open = !open"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 transition hover:text-slate-600"
            aria-label="Toggle time picker"
        >
            <i data-lucide="chevron-down" class="h-4 w-4"></i>
        </button>
    </div>

    <div
        x-show="open"
        x-transition.origin.top.left
        x-cloak
        @click.away="open = false"
        class="absolute z-50 mt-2 w-[320px] max-w-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl"
    >
        <div class="flex items-center justify-between border-b border-slate-100 px-3 py-2">
            <p class="text-sm font-semibold text-slate-700">Select Time</p>
            <button type="button" @click="setNow()" class="rounded-lg bg-primary/10 px-2 py-1 text-xs font-medium text-primary hover:bg-primary/20">
                Now
            </button>
        </div>

        <div class="grid grid-cols-3 gap-2 p-3">
            <div>
                <p class="mb-2 text-[11px] font-medium uppercase tracking-wide text-slate-400">Hour</p>
                <div class="max-h-44 space-y-1 overflow-y-auto pr-1">
                    <template x-for="hour in hours" :key="`h-${hour}`">
                        <button
                            type="button"
                            @click="selectedHour = hour; applySelection()"
                            class="w-full rounded-lg px-2 py-1.5 text-sm"
                            :class="selectedHour === hour ? 'bg-primary text-white' : 'text-slate-700 hover:bg-slate-100'"
                            x-text="hour"
                        ></button>
                    </template>
                </div>
            </div>

            <div>
                <p class="mb-2 text-[11px] font-medium uppercase tracking-wide text-slate-400">Min</p>
                <div class="max-h-44 space-y-1 overflow-y-auto pr-1">
                    <template x-for="minute in minuteSteps" :key="`m-${minute}`">
                        <button
                            type="button"
                            @click="selectedMinute = minute; applySelection()"
                            class="w-full rounded-lg px-2 py-1.5 text-sm"
                            :class="selectedMinute === minute ? 'bg-primary text-white' : 'text-slate-700 hover:bg-slate-100'"
                            x-text="minute"
                        ></button>
                    </template>
                </div>
            </div>

            <div>
                <p class="mb-2 text-[11px] font-medium uppercase tracking-wide text-slate-400">Period</p>
                <div class="space-y-1">
                    <button
                        type="button"
                        @click="selectedPeriod = 'AM'; applySelection()"
                        class="w-full rounded-lg px-2 py-1.5 text-sm"
                        :class="selectedPeriod === 'AM' ? 'bg-primary text-white' : 'text-slate-700 hover:bg-slate-100'"
                    >
                        AM
                    </button>
                    <button
                        type="button"
                        @click="selectedPeriod = 'PM'; applySelection()"
                        class="w-full rounded-lg px-2 py-1.5 text-sm"
                        :class="selectedPeriod === 'PM' ? 'bg-primary text-white' : 'text-slate-700 hover:bg-slate-100'"
                    >
                        PM
                    </button>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between border-t border-slate-100 px-3 py-2">
            <button type="button" @click="clearTime()" class="text-xs font-medium text-slate-500 hover:text-slate-700">Clear</button>
            <button type="button" @click="done()" class="rounded-lg bg-primary px-3 py-1.5 text-xs font-medium text-white hover:bg-primary/90">Done</button>
        </div>
    </div>
</div>

@once
<script>
if (!window.timePickerComponent) {
    window.timePickerComponent = function(initialValue) {
        function pad(v) {
            return String(v).padStart(2, '0');
        }

        function normalize(input) {
            if (!input) return '';
            const value = String(input).trim().toUpperCase().replace(/\s+/g, ' ');
            const match12 = value.match(/^(\d{1,2}):(\d{2})\s?(AM|PM)$/);
            if (match12) {
                const h = Math.min(Math.max(Number(match12[1]), 1), 12);
                const m = Math.min(Math.max(Number(match12[2]), 0), 59);
                return `${pad(h)}:${pad(m)} ${match12[3]}`;
            }

            const match24 = value.match(/^(\d{1,2}):(\d{2})$/);
            if (match24) {
                let h24 = Math.min(Math.max(Number(match24[1]), 0), 23);
                const m = Math.min(Math.max(Number(match24[2]), 0), 59);
                const period = h24 >= 12 ? 'PM' : 'AM';
                let h12 = h24 % 12;
                if (h12 === 0) h12 = 12;
                return `${pad(h12)}:${pad(m)} ${period}`;
            }

            return value.replace(/[^0-9:APM\s]/g, '').slice(0, 8);
        }

        function parseParts(value) {
            const normalized = normalize(value);
            const match = normalized.match(/^(\d{2}):(\d{2})\s(AM|PM)$/);
            if (!match) return null;
            return { hour: match[1], minute: match[2], period: match[3] };
        }

        const normalizedInitial = normalize(initialValue);
        const parsedInitial = parseParts(normalizedInitial) || { hour: '02', minute: '15', period: 'PM' };

        return {
            open: false,
            displayValue: normalizedInitial || '',
            selectedHour: parsedInitial.hour,
            selectedMinute: parsedInitial.minute,
            selectedPeriod: parsedInitial.period,
            hours: Array.from({ length: 12 }, (_, i) => pad(i + 1)),
            minuteSteps: Array.from({ length: 12 }, (_, i) => pad(i * 5)),

            onInput() {
                this.displayValue = normalize(this.displayValue);
                const parsed = parseParts(this.displayValue);
                if (parsed) {
                    this.selectedHour = parsed.hour;
                    this.selectedMinute = parsed.minute;
                    this.selectedPeriod = parsed.period;
                }
            },

            normalizeInput() {
                const parsed = parseParts(this.displayValue);
                if (parsed) {
                    this.displayValue = `${parsed.hour}:${parsed.minute} ${parsed.period}`;
                }
            },

            applySelection() {
                this.displayValue = `${this.selectedHour}:${this.selectedMinute} ${this.selectedPeriod}`;
            },

            setNow() {
                const now = new Date();
                let h = now.getHours();
                const period = h >= 12 ? 'PM' : 'AM';
                h = h % 12;
                if (h === 0) h = 12;
                const roundedMin = Math.floor(now.getMinutes() / 5) * 5;
                this.selectedHour = pad(h);
                this.selectedMinute = pad(roundedMin);
                this.selectedPeriod = period;
                this.applySelection();
            },

            clearTime() {
                this.displayValue = '';
                this.open = false;
            },

            done() {
                const currentValue = (this.displayValue || '').trim();
                if (!currentValue) {
                    this.open = false;
                    return;
                }

                const parsed = parseParts(currentValue);
                if (parsed) {
                    this.selectedHour = parsed.hour;
                    this.selectedMinute = parsed.minute;
                    this.selectedPeriod = parsed.period;
                    this.displayValue = `${parsed.hour}:${parsed.minute} ${parsed.period}`;
                } else {
                    this.applySelection();
                }

                this.open = false;
            },
        };
    };
}
</script>
@endonce
