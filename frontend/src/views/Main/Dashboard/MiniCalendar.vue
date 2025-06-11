<!-- MiniCalendar.vue (Enhanced) -->
<template>
    <div class="col-span-1 row-span-2 box bg-base-100  transition-all duration-300 hover:scale-[1.01] border border-base-300/50">
        <div class="mini-calendar p-4 w-full rounded-lg h-full flex flex-col">
            <!-- Header -->
            <div class="flex flex-row justify-between items-center border-b border-base-300/50 mb-4 pb-4 bg-gradient-to-r from-primary/10 to-secondary/10 -m-4 px-4 py-4 rounded-t-4xl">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-primary/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">{{ monthName }} {{ year }}</span>
                </div>
                <div class="flex items-center gap-1 bg-base-200/50 rounded-lg p-1">
                    <button @click="prevMonth" class="btn btn-sm btn-ghost btn-circle hover:bg-primary/10 hover:text-primary transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button @click="nextMonth" class="btn btn-sm btn-ghost btn-circle hover:bg-primary/10 hover:text-primary transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Days of Week -->
            <div class="days grid grid-cols-7 text-center mb-2">
                <div class="day text-sm font-bold py-2 text-base-content/60" v-for="day in daysOfWeek" :key="day">{{ day }}</div>
            </div>
            
            <!-- Calendar Dates -->
            <div class="dates grid grid-cols-7 text-center flex-auto gap-1">
                <div
                    v-for="date in dates"
                    :key="date.key"
                    @click="selectDate(date)"
                    :class="[
                        'date py-2 text-sm font-medium cursor-pointer flex justify-center items-center rounded-lg transition-all duration-200 hover:scale-110',
                        {
                            'text-base-content/40 hover:text-base-content/60': !date.isCurrentMonth,
                            'bg-gradient-to-r from-primary to-primary/80 text-primary-content shadow-lg scale-110': date.isToday,
                            'bg-gradient-to-r from-secondary/20 to-secondary/10 text-secondary border border-secondary/30': isSelected(date) && !date.isToday,
                            'text-base-content hover:bg-base-200 hover:text-primary': date.isCurrentMonth && !date.isToday && !isSelected(date),
                            'relative': hasEvents(date)
                        }
                    ]"
                >
                    {{ date.day }}
                    <!-- Event Indicator -->
                    <div v-if="hasEvents(date)" class="absolute bottom-1 left-1/2 transform -translate-x-1/2 w-1.5 h-1.5 bg-accent rounded-full"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'MiniCalendar',
    data() {
        return {
            currentDate: new Date(),
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            selectedDate: null,
            // Sample events data - you can replace this with actual data
            events: [
                { date: new Date().toDateString() }, // Today has an event
                { date: new Date(Date.now() + 24 * 60 * 60 * 1000).toDateString() } // Tomorrow has an event
            ]
        };
    },
    computed: {
        year() {
            return this.currentDate.getFullYear();
        },
        month() {
            return this.currentDate.getMonth();
        },
        monthName() {
            return this.currentDate.toLocaleString('default', { month: 'long' });
        },
        formatSelectedDate() {
            if (!this.selectedDate) return '';
            return `${this.selectedDate.monthName} ${this.selectedDate.day}, ${this.selectedDate.year}`;
        },
        dates() {
            const firstDayOfMonth = new Date(this.year, this.month, 1);
            const lastDayOfMonth = new Date(this.year, this.month + 1, 0);
            const startDay = firstDayOfMonth.getDay();
            const daysInMonth = lastDayOfMonth.getDate();
            const today = new Date();
            const dates = [];

            // Previous month's trailing days
            const prevMonth = this.month === 0 ? 11 : this.month - 1;
            const prevYear = this.month === 0 ? this.year - 1 : this.year;
            const prevMonthLastDay = new Date(this.year, this.month, 0).getDate();
        
            for (let i = startDay - 1; i >= 0; i--) {
                const day = prevMonthLastDay - i;
                dates.push({
                    day,
                    isCurrentMonth: false,
                    isToday: false,
                    key: `prev-${i}`,
                    month: prevMonth,
                    year: prevYear
                });
            }

            // Current month's days
            for (let i = 1; i <= daysInMonth; i++) {
                const isToday =
                    i === today.getDate() &&
                    this.month === today.getMonth() &&
                    this.year === today.getFullYear();
                dates.push({
                    day: i,
                    isCurrentMonth: true,
                    isToday,
                    key: `curr-${i}`,
                    month: this.month,
                    year: this.year
                });
            }

            // Next month's starting days
            const nextMonth = this.month === 11 ? 0 : this.month + 1;
            const nextYear = this.month === 11 ? this.year + 1 : this.year;
            const totalSlots = Math.ceil((startDay + daysInMonth) / 7) * 7;
        
            for (let i = 1; dates.length < totalSlots; i++) {
                dates.push({
                    day: i,
                    isCurrentMonth: false,
                    isToday: false,
                    key: `next-${i}`,
                    month: nextMonth,
                    year: nextYear
                });
            }

            return dates;
        },
    },
    methods: {
        prevMonth() {
            this.currentDate = new Date(this.year, this.month - 1, 1);
        },
        nextMonth() {
            this.currentDate = new Date(this.year, this.month + 1, 1);
        },
        selectDate(date) {
            this.selectedDate = {
                day: date.day,
                month: date.month,
                year: date.year,
                monthName: new Date(date.year, date.month, 1).toLocaleString('default', { month: 'long' }),
                fullDate: new Date(date.year, date.month, date.day)
            };
            
            // Emit event to notify parent components
            this.$emit('date-selected', this.selectedDate);
        },
        isSelected(date) {
            if (!this.selectedDate) return false;
            return (
                date.day === this.selectedDate.day &&
                date.month === this.selectedDate.month &&
                date.year === this.selectedDate.year
            );
        },
        hasEvents(date) {
            const dateString = new Date(date.year, date.month, date.day).toDateString();
            return this.events.some(event => event.date === dateString);
        }
    }
};
</script>