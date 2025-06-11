<template>
    <div class="row-span-2 box bg-base-100  transition-all duration-300 hover:scale-[1.01] border border-base-300/50">
        <!-- Header -->
        <div class="flex flex-row justify-between items-center border-b border-base-300/50 rounded-t-4xl h-16 bg-gradient-to-r from-error/10 to-error/5 px-6"> 
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-xl bg-error/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-error" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <p class="font-bold text-xl bg-gradient-to-r from-error to-error/80 bg-clip-text text-transparent">Missed Tasks</p>
            </div>
            <div class="badge badge-error badge-outline font-semibold">{{ missedCount }}</div>
        </div>
        
        <!-- Content -->
        <div class="p-4 space-y-3 max-h-[calc(100%-4rem)] overflow-y-auto">
            <div v-if="missedTasks.length === 0" class="flex flex-col items-center justify-center h-32 text-center">
                <div class="p-4 rounded-full bg-success/10 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-base-content/60 font-medium">No missed tasks</p>
                <p class="text-sm text-base-content/40">Keep up the great work!</p>
            </div>
            
            <div v-for="task in missedTasks" :key="task.id" 
                 class="group p-3 rounded-xl bg-gradient-to-r from-base-200/50 to-base-300/30 border border-base-300/30 hover:border-error/30 hover:shadow-md transition-all duration-300 hover:scale-[1.02]">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h4 class="font-semibold text-base-content group-hover:text-error transition-colors">{{ task.title }}</h4>
                        <p class="text-sm text-base-content/60 mt-1">{{ task.description }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <div class="badge badge-sm badge-error badge-outline">
                                {{ formatDate(task.dueDate) }}
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-ghost btn-circle opacity-0 group-hover:opacity-100 transition-opacity hover:bg-error/10 hover:text-error">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            missedTasks: [
                {
                    id: 1,
                    title: "Submit Project Report",
                    description: "Final project documentation",
                    dueDate: new Date('2024-06-05'),
                },
                {
                    id: 2,
                    title: "Team Meeting",
                    description: "Weekly sync with development team",
                    dueDate: new Date('2024-06-08'),
                }
            ]
        }
    },
    computed: {
        missedCount() {
            return this.missedTasks.length;
        }
    },
    methods: {
        formatDate(date) {
            return date.toLocaleDateString('en-US', { 
                month: 'short', 
                day: 'numeric',
                year: 'numeric'
            });
        }
    }
}
</script>