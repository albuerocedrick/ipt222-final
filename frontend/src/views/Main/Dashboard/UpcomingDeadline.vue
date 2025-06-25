<template>
    <div class="col-span-2 row-span-3 box bg-base-100 transition-all duration-300 hover:scale-[1.01] border border-base-300/50">
        <!-- Header -->
        <div class="flex flex-row justify-between items-center border-b border-base-300/50 rounded-t-4xl h-20 bg-gradient-to-r from-warning/10 to-warning/5 px-6"> 
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-lg bg-warning/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="font-bold text-2xl bg-gradient-to-r from-warning to-warning/80 bg-clip-text text-transparent">Upcoming Deadlines</p>
            </div>
            <div class="badge badge-warning badge-outline font-semibold">{{ upcomingTasks.length }}</div>
        </div>
        
        <!-- Content -->
        <div class="p-6 space-y-4 max-h-[calc(100%-5rem)] overflow-y-auto">
            <div v-if="loading" class="flex flex-col items-center justify-center h-40 text-center">
                <span class="loading loading-spinner loading-lg text-warning"></span>
                <p class="mt-4 text-base-content/60">Loading deadlines...</p>
            </div>
            
            <div v-else-if="upcomingTasks.length === 0" class="flex flex-col items-center justify-center h-40 text-center">
                <div class="p-4 rounded-full bg-success/10 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-base-content/60 font-medium text-lg">No upcoming deadlines</p>
                <p class="text-sm text-base-content/40">You're ahead of schedule!</p>
            </div>
            
            <div v-for="task in upcomingTasks" :key="task.task_id" 
                 class="group p-4 rounded-2xl bg-gradient-to-r from-base-200/50 to-base-300/30 border border-base-300/30 hover:border-warning/30 hover:shadow-lg transition-all duration-300 hover:scale-[1.02]">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h3 class="font-bold text-lg text-base-content group-hover:text-warning transition-colors">{{ task.title }}</h3>
                                <p class="text-sm text-base-content/60 mt-1">{{ task.description }}</p>
                            </div>
                            <div class="flex flex-col items-end gap-2 w-2/5">
                                <div class="badge" :class="getStatusColor(task.status)">
                                    {{ task.status }}
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-semibold" :class="getTimeColor(task.due_date)">
                                        {{ formatDueDate(task.due_date) }}
                                    </div>
                                    <div class="text-xs text-base-content/40">
                                        {{ formatDate(task.due_date) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="badge badge-sm badge-ghost">
                                    {{ task.project_name || 'No Project' }}
                                </div>
                            </div>
                            <!-- <button @click="viewTaskDetails(task)" class="btn btn-sm btn-outline hover:scale-105 transition-transform">
                                View Details
                            </button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            upcomingTasks: [],
            loading: true,
            error: null
        }
    },
    mounted() {
        this.fetchUpcomingTasks();
    },
    methods: {
        async fetchUpcomingTasks() {
            try {
                const user = JSON.parse(localStorage.getItem('user'));

                if (!user.id) {
                    this.error = 'User not authenticated';
                    this.loading = false;
                    return;
                }

                const response = await axios.get('https://act-track.x10.mx/index.php/fetch-upcoming-tasks', {
                    params: {
                        user_id: user.id,
                        days_ahead: 7 // Get tasks due in the next 7 days
                    }
                });

                if (response.data.success) {
                    this.upcomingTasks = response.data.tasks.map(task => ({
                        ...task,
                        due_date: new Date(task.due_date)
                    }));
                } else {
                    this.error = response.data.message || 'Failed to fetch tasks';
                }
            } catch (err) {
                console.error('Error fetching upcoming tasks:', err);
                this.error = 'Failed to load upcoming tasks';
            } finally {
                this.loading = false;
            }
        },
        getStatusColor(status) {
            const colors = {
                'In Progress': 'badge-info badge-outline',
                'Not Started': 'badge-neutral badge-outline',
                'Near Deadline': 'badge-warning badge-outline',
                'Done': 'badge-success badge-outline',
                'Submitted Late': 'badge-error badge-outline',
                'Missed': 'badge-error badge-outline'
            };
            return colors[status] || 'badge-neutral badge-outline';
        },
        getTimeColor(dueDate) {
            const now = new Date();
            const diff = new Date(dueDate) - now;
            const days = Math.floor(diff / (24 * 60 * 60 * 1000));
            
            if (days <= 1) return 'text-error';
            if (days <= 3) return 'text-warning';
            return 'text-base-content';
        },
        formatDueDate(dueDate) {
            const now = new Date();
            const diff = new Date(dueDate) - now;
            const days = Math.floor(diff / (24 * 60 * 60 * 1000));
            const hours = Math.floor((diff % (24 * 60 * 60 * 1000)) / (60 * 60 * 1000));
            
            if (days === 0) return `${hours}h left`;
            if (days === 1) return 'Tomorrow';
            return `${days} days left`;
        },
        formatDate(dateString) {
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(dateString).toLocaleDateString(undefined, options);
        },
        viewTaskDetails(task) {
            // Emit event or navigate to task details
            this.$emit('view-task', task);
        }
    }
}
</script>