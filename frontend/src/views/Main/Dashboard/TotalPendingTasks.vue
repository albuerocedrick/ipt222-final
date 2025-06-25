<template>
    <div class="cols-span-1 row-span-1 box flex flex-col justify-center text-center relative overflow-hidden bg-gradient-to-br from-warning to-warning/80 text-warning-content transition-all duration-300 hover:scale-[1.02]">
        <!-- Background Decoration -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-10 translate-x-10"></div>
        <div class="absolute bottom-0 left-0 w-16 h-16 bg-white/5 rounded-full translate-y-8 -translate-x-8"></div>
        
        <!-- Loading State -->
        <div v-if="loading" class="flex flex-col items-center justify-center p-4">
            <span class="loading loading-spinner loading-lg"></span>
            <p class="mt-2">Loading task data...</p>
        </div>
        
        <!-- Error State -->
        <div v-else-if="error" class="flex flex-col items-center justify-center p-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-error" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <p class="mt-2 font-medium">{{ error }}</p>
        </div>
        
        <!-- Content -->
        <div v-else>
            <!-- Icon Container -->
            <div class="mb-3 flex justify-center">
                <div class="p-3 rounded-full bg-white/20 backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            
            <!-- Count -->
            <p class="font-black text-5xl mb-2 drop-shadow-lg">{{ pendingTasks }}</p>
            
            <!-- Label -->
            <p class="font-semibold text-lg tracking-wide opacity-90">Pending Tasks</p>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'PendingTasksCard',
    data() {
        return {
            loading: true,
            error: null,
            pendingTasks: 0,
            userId: null
        }
    },
    methods: {
        getUserIdFromStorage() {
            try {
                const userData = localStorage.getItem('user');
                if (userData) {
                    const user = JSON.parse(userData);
                    return user.id || null;
                }
                return null;
            } catch (e) {
                console.error('Error parsing user data:', e);
                return null;
            }
        },
        async fetchPendingTasks() {
            this.loading = true;
            this.error = null;
            this.userId = this.getUserIdFromStorage();
            
            if (!this.userId) {
                this.error = 'User not authenticated';
                this.loading = false;
                return;
            }
            
            try {
                const response = await axios.get('https://act-track.x10.mx/index.php/fetch-pending-tasks', {
                    params: { user_id: this.userId }
                });
                
                if (response.data.success) {
                    this.pendingTasks = response.data.pending_tasks;
                } else {
                    this.error = response.data.message || 'Failed to fetch pending tasks';
                }
            } catch (err) {
                this.error = err.response?.data?.message || err.message;
                console.error('Error:', this.error);
            } finally {
                this.loading = false;
            }
        }
    },
    mounted() {
        this.fetchPendingTasks();
    }
}
</script>