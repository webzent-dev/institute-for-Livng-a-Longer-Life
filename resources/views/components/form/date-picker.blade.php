@props([
    'name',
    'label' => null,
    'id' => null,
    'value' => null,
    'required' => false,
    'placeholder' => 'dd-mm-yyyy',
    'class' => '',
])

@php
    $inputId = $id ?: 'dt_' . preg_replace('/[^a-z0-9_]/i', '_', $name);
    $oldValue = old($name, $value);
@endphp

<div x-data="datePickerComponent(@js($oldValue))" class="relative w-full {{ $class }}">
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
        <i data-lucide="calendar-days" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>

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
            inputmode="numeric"
            autocomplete="off"
            @if($required) required @endif
            class="flex h-11 w-full rounded-xl border border-slate-200 bg-white px-10 py-2 text-[14px] text-slate-700 placeholder:text-[14px] placeholder:text-slate-400 shadow-sm ring-offset-background transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/20"
        >

        <button
            type="button"
            @click="open = !open"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 transition hover:text-slate-600"
            aria-label="Toggle date picker"
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
            <div class="flex items-center gap-1">
                <button type="button" @click="prevMonth()" class="rounded-lg p-1.5 text-slate-500 hover:bg-slate-100" aria-label="Previous month">
                    <i data-lucide="chevron-left" class="h-4 w-4"></i>
                </button>
                <button type="button" @click="nextMonth()" class="rounded-lg p-1.5 text-slate-500 hover:bg-slate-100" aria-label="Next month">
                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                </button>
            </div>

            <p class="text-sm font-semibold text-slate-700" x-text="monthYearLabel()"></p>

            <button type="button" @click="setToday()" class="rounded-lg bg-primary/10 px-2 py-1 text-xs font-medium text-primary hover:bg-primary/20">
                Today
            </button>
        </div>

        <div class="grid grid-cols-7 gap-1 px-3 pt-3 text-center text-[11px] font-medium uppercase tracking-wide text-slate-400">
            <template x-for="day in ['Su','Mo','Tu','We','Th','Fr','Sa']" :key="day">
                <span x-text="day"></span>
            </template>
        </div>

        <div class="grid grid-cols-7 gap-1 p-3 pt-2 text-sm">
            <template x-for="cell in daysGrid()" :key="cell.key">
                <button
                    type="button"
                    :disabled="!cell.inMonth"
                    @click="selectDate(cell.date)"
                    class="h-9 rounded-xl text-center transition disabled:cursor-default"
                    :class="dayClasses(cell)"
                    x-text="cell.day"
                ></button>
            </template>
        </div>

        <div class="flex items-center justify-between border-t border-slate-100 px-3 py-2">
            <button type="button" @click="clearDate()" class="text-xs font-medium text-slate-500 hover:text-slate-700">Clear</button>
            <button type="button" @click="done()" class="rounded-lg bg-primary px-3 py-1.5 text-xs font-medium text-white hover:bg-primary/90">Done</button>
        </div>
    </div>
</div>

@once
<script>
if (!window.datePickerComponent) {
    window.datePickerComponent = function(initialValue) {
        const now = new Date();

        function validDate(y, m, d) {
            const date = new Date(y, m - 1, d);
            return date.getFullYear() === y && date.getMonth() === (m - 1) && date.getDate() === d;
        }

        function parseDate(value) {
            if (!value) return null;
            const raw = String(value).trim();
            let match = raw.match(/^(\d{2})-(\d{2})-(\d{4})$/);
            if (match) {
                const d = Number(match[1]);
                const m = Number(match[2]);
                const y = Number(match[3]);
                if (!validDate(y, m, d)) return null;
                return new Date(y, m - 1, d);
            }
            match = raw.match(/^(\d{4})-(\d{2})-(\d{2})$/);
            if (match) {
                const y = Number(match[1]);
                const m = Number(match[2]);
                const d = Number(match[3]);
                if (!validDate(y, m, d)) return null;
                return new Date(y, m - 1, d);
            }
            return null;
        }

        function toDisplay(date) {
            const dd = String(date.getDate()).padStart(2, '0');
            const mm = String(date.getMonth() + 1).padStart(2, '0');
            const yyyy = date.getFullYear();
            return `${dd}-${mm}-${yyyy}`;
        }

        function isSameDay(a, b) {
            return a && b && a.toDateString() === b.toDateString();
        }

        const parsed = parseDate(initialValue);

        return {
            open: false,
            displayValue: parsed ? toDisplay(parsed) : '',
            selectedDate: parsed,
            today: now,
            viewMonth: parsed ? parsed.getMonth() : now.getMonth(),
            viewYear: parsed ? parsed.getFullYear() : now.getFullYear(),

            onInput() {
                let digits = this.displayValue.replace(/\D/g, '').slice(0, 8);
                if (digits.length > 4) {
                    this.displayValue = `${digits.slice(0, 2)}-${digits.slice(2, 4)}-${digits.slice(4)}`;
                } else if (digits.length > 2) {
                    this.displayValue = `${digits.slice(0, 2)}-${digits.slice(2)}`;
                } else {
                    this.displayValue = digits;
                }

                const parsedInput = parseDate(this.displayValue);
                if (parsedInput) {
                    this.selectedDate = parsedInput;
                    this.viewMonth = parsedInput.getMonth();
                    this.viewYear = parsedInput.getFullYear();
                }
            },

            normalizeInput() {
                const parsedInput = parseDate(this.displayValue);
                if (parsedInput) {
                    this.displayValue = toDisplay(parsedInput);
                }
            },

            monthYearLabel() {
                return new Date(this.viewYear, this.viewMonth, 1).toLocaleString('en-US', {
                    month: 'long',
                    year: 'numeric'
                });
            },

            prevMonth() {
                if (this.viewMonth === 0) {
                    this.viewMonth = 11;
                    this.viewYear -= 1;
                } else {
                    this.viewMonth -= 1;
                }
            },

            nextMonth() {
                if (this.viewMonth === 11) {
                    this.viewMonth = 0;
                    this.viewYear += 1;
                } else {
                    this.viewMonth += 1;
                }
            },

            daysGrid() {
                const firstDay = new Date(this.viewYear, this.viewMonth, 1);
                const startWeekDay = firstDay.getDay();
                const daysInMonth = new Date(this.viewYear, this.viewMonth + 1, 0).getDate();
                const daysInPrevMonth = new Date(this.viewYear, this.viewMonth, 0).getDate();
                const cells = [];

                for (let i = startWeekDay - 1; i >= 0; i--) {
                    const day = daysInPrevMonth - i;
                    cells.push({
                        key: `p-${day}`,
                        day,
                        inMonth: false,
                        date: new Date(this.viewYear, this.viewMonth - 1, day),
                    });
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    cells.push({
                        key: `c-${day}`,
                        day,
                        inMonth: true,
                        date: new Date(this.viewYear, this.viewMonth, day),
                    });
                }

                while (cells.length < 42) {
                    const day = cells.length - (startWeekDay + daysInMonth) + 1;
                    cells.push({
                        key: `n-${day}`,
                        day,
                        inMonth: false,
                        date: new Date(this.viewYear, this.viewMonth + 1, day),
                    });
                }

                return cells;
            },

            dayClasses(cell) {
                if (!cell.inMonth) return 'text-slate-300';
                if (isSameDay(this.selectedDate, cell.date)) return 'bg-primary text-white shadow-sm';
                if (isSameDay(this.today, cell.date)) return 'bg-primary/10 text-primary font-semibold';
                return 'text-slate-700 hover:bg-slate-100';
            },

            selectDate(date) {
                this.selectedDate = date;
                this.displayValue = toDisplay(date);
                this.open = false;
            },

            setToday() {
                this.selectDate(new Date());
            },

            clearDate() {
                this.selectedDate = null;
                this.displayValue = '';
                this.open = false;
            },

            done() {
                const parsedInput = parseDate(this.displayValue);
                if (parsedInput) {
                    this.selectedDate = parsedInput;
                    this.displayValue = toDisplay(parsedInput);
                } else if (this.selectedDate) {
                    this.displayValue = toDisplay(this.selectedDate);
                }
                this.open = false;
            },
        };
    };
}
</script>
@endonce
