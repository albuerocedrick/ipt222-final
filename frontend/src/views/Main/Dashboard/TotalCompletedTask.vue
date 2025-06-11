<template>
    <div class="cols-span-1 row-span-1 box flex flex-col justify-center text-center relative overflow-hidden bg-gradient-to-br from-success to-success/80 text-success-content  transition-all duration-300 hover:scale-[1.02]">
        <!-- Background Decoration -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-10 translate-x-10"></div>
        <div class="absolute bottom-0 left-0 w-16 h-16 bg-white/5 rounded-full translate-y-8 -translate-x-8"></div>
        
        <!-- Icon Container -->
        <div class="mb-3 flex justify-center">
            <div class="p-3 rounded-full bg-white/20 backdrop-blur-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        
        <!-- Count -->
        <p class="font-black text-5xl mb-2 drop-shadow-lg">{{ completedTasks }}</p>
        
        <!-- Label -->
        <p class="font-semibold text-lg tracking-wide opacity-90">Tasks Completed</p>
        
        <!-- Progress Indicator -->
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-white/20">
            <div class="h-full bg-white/40 rounded-full transition-all duration-1000" :style="`width: ${completionPercentage}%`"></div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            completedTasks: 12, // Replace with actual data
            totalTasks: 20 // Replace with actual data
        }
    },
    computed: {
        completionPercentage() {
            return this.totalTasks > 0 ? (this.completedTasks / this.totalTasks) * 100 : 0;
        }
    }
}
</script>