<template>
    <div class="col-span-2 row-span-2 rounded-2xl bg-[#EBE8E2]">
        <div :class="['mini-calendar p-4 box w-full rounded-lg h-full flex flex-col', 'box ']">
            <div class="header flex justify-between items-center mb-3 bg-[#a2cffe] rounded-lg px-2">
                <button @click="prevMonth" class="text-lg p-1  font-bold">&lt;</button>
                <span class="font-bold text-base ">{{ monthName }} {{ year }}</span>
                <button @click="nextMonth" class="text-lg p-1  font-bold">&gt;</button>
            </div>
            <div class="days grid grid-cols-7 text-center">
                <div :class="['day text-md font-bold py-2']" v-for="day in daysOfWeek" :key="day">{{ day }}</div>
            </div>
            <div class="dates grid grid-cols-7 text-center flex-auto">
                <div
                    v-for="date in dates"
                    :key="date.key"
                    :class="[
                    'date py-2 text-md font-medium cursor-pointer flex justify-center text-center items-center',
                    {
                        'text-gray-500': !date.isCurrentMonth,
                        'bg-[#a2cffe] rounded-full': date.isToday,
                        'bg-gray-200 rounded-full': isSelected(date) && !date.isToday
                    },
                    !date.isToday && !isSelected(date) && date.isCurrentMonth ? 'text-black' : ''
                    ]"
                    @click="selectDate(date)"
                >
                    {{ date.day }}
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
            selectedDate: null
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
            return `${this.selectedDate.day}/${this.selectedDate.month}/${this.selectedDate.year}`;
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
            
            // You can emit an event to notify parent components about the selection
            this.$emit('date-selected', this.selectedDate);
            },
            isSelected(date) {
            if (!this.selectedDate) return false;
            return (
                date.day === this.selectedDate.day &&
                date.month === this.selectedDate.month &&
                date.year === this.selectedDate.year
            );
        }
    }
};
</script>