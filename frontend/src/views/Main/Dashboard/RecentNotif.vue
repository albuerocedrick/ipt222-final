<template>
    <div class="row-span-4 box bg-base-100 transition-all duration-300 hover:scale-[1.01] border border-base-300/50">
        <!-- Header -->
        <div class="flex flex-row justify-between items-center border-b border-base-300/50 rounded-t-4xl h-16 bg-gradient-to-r from-info/10 to-info/5 px-4"> 
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-lg bg-info/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-info" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-5 5v-5zM4 3h16v12H4z" />
                    </svg>
                </div>
                <p class="font-bold text-xl bg-gradient-to-r from-info to-info/80 bg-clip-text text-transparent">Notifications</p>
            </div>
            <div class="flex items-center gap-2">
                <div class="badge badge-info badge-outline font-semibold">{{ unreadCount }}/{{ notifications.length }}</div>
                <button @click="markAllAsRead" class="btn btn-xs btn-ghost" :disabled="unreadCount === 0">
                    Mark all read
                </button>
            </div>
        </div>
        
        <!-- Content -->
        <div class="p-4 space-y-3 max-h-[calc(100%-4rem)] overflow-y-auto">
            <div v-if="loading" class="flex flex-col items-center justify-center h-32 text-center">
                <span class="loading loading-spinner loading-lg text-info"></span>
                <p class="mt-3 text-base-content/60 font-medium">Loading notifications...</p>
            </div>
            
            <div v-else-if="notifications.length === 0" class="flex flex-col items-center justify-center h-32 text-center">
                <div class="p-4 rounded-full bg-info/10 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-info" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <p class="text-base-content/60 font-medium">No notifications</p>
                <p class="text-sm text-base-content/40">You're all caught up!</p>
            </div>
            
            <div v-for="notification in notifications" :key="notification.notification_id" 
                 @click="markAsRead(notification.notification_id)"
                 class="group p-3 rounded-xl bg-gradient-to-r from-base-200/50 to-base-300/30 border border-base-300/30 hover:border-info/30 hover:shadow-md transition-all duration-300 hover:scale-[1.02] cursor-pointer">
                <div class="flex items-start gap-3">
                    <!-- Notification Icon -->
                    <div class="flex-shrink-0 p-2 rounded-lg transition-all duration-300"
                         :class="getNotificationColor(notification.type).bg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" :class="getNotificationColor(notification.type).text" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path v-if="notification.type.includes('task')" stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            <path v-else-if="notification.type.includes('deadline')" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            <path v-else stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    
                    <!-- Notification Content -->
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="font-semibold text-base-content group-hover:text-info transition-colors">
                                    {{ formatTitle(notification.type) }}
                                </h4>
                                <p class="text-sm text-base-content/60 mt-1">{{ notification.message }}</p>
                                <div v-if="notification.project_name" class="text-xs text-info mt-1">
                                    Project: {{ notification.project_name }}
                                </div>
                                <div v-if="notification.task_title" class="text-xs text-warning mt-1">
                                    Task: {{ notification.task_title }}
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1">
                                <span class="text-xs text-base-content/40">{{ formatTime(notification.created_at) }}</span>
                                <div v-if="!notification.is_read" class="w-2 h-2 bg-info rounded-full"></div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 mt-2">
                            <div class="badge badge-sm" :class="getNotificationColor(notification.type).badge">
                                {{ formatType(notification.type) }}
                            </div>
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
            notifications: [],
            loading: false,
            error: null,
            currentUserId: null // You'll need to set this from your auth system
        }
    },
    computed: {
        unreadCount() {
            return this.notifications.filter(n => !n.is_read).length;
        }
    },
    mounted() {
        // Get current user ID from your authentication system
        this.currentUserId = this.getCurrentUserId(); // Implement this method
        this.fetchNotifications();
    },
    methods: {
        getCurrentUserId() {
            const user = JSON.parse(localStorage.getItem('user'));
            return user.id; // Replace with actual user ID
        },
        async fetchNotifications() {
            this.loading = true;
            this.error = null;
            try {
                const response = await axios.get('https://act-track.x10.mx/index.php/fetch-notifications', {
                    params: {
                        user_id: this.currentUserId
                    }
                });
                
                if (response.data.success) {
                    this.notifications = response.data.notifications;
                } else {
                    this.error = response.data.message || 'Failed to fetch notifications';
                    console.error(this.error);
                }
            } catch (err) {
                this.error = err.response?.data?.message || err.message;
                console.error('Error fetching notifications:', this.error);
            } finally {
                this.loading = false;
            }
        },
        async markAsRead(notificationId) {
            try {
                const response = await axios.put('https://act-track.x10.mx/index.php/mark-notification-read', {
                    user_id: this.currentUserId,
                    notification_id: notificationId
                });
                
                if (response.data.success) {
                    // Update local state
                    const index = this.notifications.findIndex(n => n.notification_id === notificationId);
                    if (index !== -1) {
                        this.notifications[index].is_read = true;
                    }
                } else {
                    console.error('Failed to mark notification as read:', response.data.message);
                }
            } catch (err) {
                console.error('Error marking notification as read:', err.response?.data?.message || err.message);
            }
        },
        async markAllAsRead() {
            if (this.unreadCount === 0) return;
            
            try {
                const response = await axios.put('https://act-track.x10.mx/index.php/mark-all-notifications-read', {
                    user_id: this.currentUserId
                });
                
                if (response.data.success) {
                    // Update all notifications to read
                    this.notifications = this.notifications.map(n => ({ ...n, is_read: true }));
                } else {
                    console.error('Failed to mark all notifications as read:', response.data.message);
                }
            } catch (err) {
                console.error('Error marking all notifications as read:', err.response?.data?.message || err.message);
            }
        },
        getNotificationColor(type) {
            const colors = {
                'task_status_updated': {
                    bg: 'bg-success/10',
                    text: 'text-success',
                    badge: 'badge-success badge-outline'
                },
                'task_deadline_approaching': {
                    bg: 'bg-warning/10',
                    text: 'text-warning',
                    badge: 'badge-warning badge-outline'
                },
                'task_missed': {
                    bg: 'bg-error/10',
                    text: 'text-error',
                    badge: 'badge-error badge-outline'
                },
                'task_submitted_late': {
                    bg: 'bg-warning/10',
                    text: 'text-warning',
                    badge: 'badge-warning badge-outline'
                },
                'task_submitted': {
                    bg: 'bg-info/10',
                    text: 'text-info',
                    badge: 'badge-info badge-outline'
                },
                'task_accepted_by_owner': {
                    bg: 'bg-success/10',
                    text: 'text-success',
                    badge: 'badge-success badge-outline'
                },
                'project_added_as_collaborator': {
                    bg: 'bg-info/10',
                    text: 'text-info',
                    badge: 'badge-info badge-outline'
                }
            };
            
            return colors[type] || colors['project_added_as_collaborator'];
        },
        formatTime(timestamp) {
            if (!timestamp) return 'Just now';
            
            const date = new Date(timestamp);
            const now = new Date();
            const diff = now - date;
            const minutes = Math.floor(diff / 60000);
            const hours = Math.floor(minutes / 60);
            const days = Math.floor(hours / 24);
            
            if (days > 0) return `${days}d ago`;
            if (hours > 0) return `${hours}h ago`;
            if (minutes > 0) return `${minutes}m ago`;
            return 'Just now';
        },
        formatType(type) {
            return type.split('_')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');
        },
        formatTitle(type) {
            switch(type) {
                case 'task_status_updated': return 'Task Status Updated';
                case 'task_deadline_approaching': return 'Deadline Approaching';
                case 'task_missed': return 'Task Deadline Missed';
                case 'task_submitted_late': return 'Task Submitted Late';
                case 'task_submitted': return 'Task Submitted';
                case 'task_accepted_by_owner': return 'Task Accepted';
                case 'project_added_as_collaborator': return 'Added to Project';
                default: return this.formatType(type);
            }
        }
    }
}
</script>