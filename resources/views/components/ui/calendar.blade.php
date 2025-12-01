<div 
    x-data="calendar()" 
    x-init="init()"
    class="w-full p-4 bg-white shadow rounded-xl"
>
    <div class="flex justify-between items-center mb-3">
        <button @click="prevMonth">&lt;</button>
        <h2 class="font-semibold" x-text="month + ' ' + year"></h2>
        <button @click="nextMonth">&gt;</button>
    </div>

    <div class="grid grid-cols-7 text-center text-sm text-gray-500 mb-2">
        <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div>
        <div>Thu</div><div>Fri</div><div>Sat</div>
    </div>

    <div class="grid grid-cols-7 gap-2">
        <template x-for="d in days">
            <div 
                class="py-2 rounded cursor-pointer"
                :class="d.today ? 'bg-primary text-white' : 'hover:bg-gray-100'"
                x-text="d.date"
            ></div>
        </template>
    </div>
</div>

<script>
function calendar() {
    return {
        date: new Date(),
        month: '',
        year: '',
        days: [],

        init() {
            this.render();
        },

        render() {
            let d = new Date(this.date);
            this.month = d.toLocaleString('default', { month: 'long' });
            this.year = d.getFullYear();

            let start = new Date(d.getFullYear(), d.getMonth(), 1);
            let end = new Date(d.getFullYear(), d.getMonth() + 1, 0);

            let arr = [];

            for (let i = 0; i < start.getDay(); i++) arr.push({ empty: true });

            for (let i = 1; i <= end.getDate(); i++) {
                let today = new Date();
                arr.push({
                    date: i,
                    today: 
                        i === today.getDate() &&
                        d.getMonth() === today.getMonth() &&
                        d.getFullYear() === today.getFullYear()
                });
            }

            this.days = arr;
        },

        prevMonth() {
            this.date.setMonth(this.date.getMonth() - 1);
            this.render();
        },

        nextMonth() {
            this.date.setMonth(this.date.getMonth() + 1);
            this.render();
        }
    }
}
</script>


{{-- how to use --}}

{{-- <x-ui.calendar /> --}}