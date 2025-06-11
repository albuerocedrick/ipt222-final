<template>
    <div class="row-span-2 box bg-base-100  transition-all duration-300 hover:scale-[1.01] border border-base-300/50">
        <!-- Header -->
        <div class="flex flex-row justify-between items-center border-b border-base-300/50 rounded-t-4xl h-16 bg-gradient-to-r from-info/10 to-info/5 px-4"> 
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-lg bg-info/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-info" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-5 5v-5zM4 3h16v12H4z" />
                    </svg>
                </div>
                <p class="font-bold text-xl bg-gradient-to-r from-info to-info/80 bg-clip-text text-transparent">Recent Notifications</p>
            </div>
            <div class="badge badge-info badge-outline font-semibold">{{ notifications.length }}</div>
        </div>
        
        <!-- Content -->
        <div class="p-4 space-y-3 max-h-[calc(100%-4rem)] overflow-y-auto">
            <div v-if="notifications.length === 0" class="flex flex-col items-center justify-center h-32 text-center">
                <div class="p-4 rounded-full bg-info/10 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-info" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <p class="text-base-content/60 font-medium">No notifications</p>
                <p class="text-sm text-base-content/40">You're all caught up!</p>
            </div>
            
            <div v-for="notification in notifications" :key="notification.id" 
                 class="group p-3 rounded-xl bg-gradient-to-r from-base-200/50 to-base-300/30 border border-base-300/30 hover:border-info/30 hover:shadow-md transition-all duration-300 hover:scale-[1.02]">
                <div class="flex items-start gap-3">
                    <!-- Notification Icon -->
                    <div class="flex-shrink-0 p-2 rounded-lg transition-all duration-300"
                         :class="getNotificationColor(notification.type).bg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" :class="getNotificationColor(notification.type).text" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path v-if="notification.type === 'task'" stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            <path v-else-if="notification.type === 'deadline'" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            <path v-else stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    
                    <!-- Notification Content -->
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="font-semibold text-base-content group-hover:text-info transition-colors">{{ notification.title }}</h4>
                                <p class="text-sm text-base-content/60 mt-1">{{ notification.message }}</p>
                            </div>
                            <div class="flex flex-col items-end gap-1">
                                <span class="text-xs text-base-content/40">{{ formatTime(notification.timestamp) }}</span>
                                <div v-if="!notification.read" class="w-2 h-2 bg-info rounded-full"></div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 mt-2">
                            <div class="badge badge-sm" :class="getNotificationColor(notification.type).badge">
                                {{ notification.type }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            notifications: [
                {
                    id: 1,
                    type: 'task',
                    title: 'Task Completed',
                    message: 'You completed "Design Dashboard UI"',
                    timestamp: new Date(Date.now() - 10 * 60 * 1000), // 10 minutes ago
                    read: false
                },
                {
                    id: 2,
                    type: 'deadline',
                    title: 'Deadline Approaching',
                    message: 'Project submission due in 2 hours',
                    timestamp: new Date(Date.now() - 30 * 60 * 1000), // 30 minutes ago
                    read: true
                },
                {
                    id: 3,
                    type: 'info',
                    title: 'Project Update',
                    message: 'New team member added to QUAMETH project',
                    timestamp: new Date(Date.now() - 2 * 60 * 60 * 1000), // 2 hours ago
                    read: true
                }
            ]
        }
    },
    methods: {
        getNotificationColor(type) {
            const colors = {
                'task': {
                    bg: 'bg-success/10',
                    text: 'text-success',
                    badge: 'badge-success badge-outline'
                },
                'deadline': {
                    bg: 'bg-warning/10',
                    text: 'text-warning',
                    badge: 'badge-warning badge-outline'
                },
                'info': {
                    bg: 'bg-info/10',
                    text: 'text-info',
                    badge: 'badge-info badge-outline'
                }
            };
            return colors[type] || colors['info'];
        },
        formatTime(timestamp) {
            const now = new Date();
            const diff = now - timestamp;
            const minutes = Math.floor(diff / 60000);
            const hours = Math.floor(minutes / 60);
            const days = Math.floor(hours / 24);
            
            if (days > 0) return `${days}d ago`;
            if (hours > 0) return `${hours}h ago`;
            if (minutes > 0) return `${minutes}m ago`;
            return 'Just now';
        }
    }
}
</script>