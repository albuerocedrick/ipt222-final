<template>
    <div class="overflow-y-auto">
        <!-- Enhanced Modal -->
        <dialog id="my_modal_4" class="modal backdrop-blur-sm">
            <div class="modal-box w-full max-w-6xl h-full max-h-[80%] bg-base-100 shadow-2xl rounded-3xl border border-primary/10">
                <!-- Modal Header -->
                <div class="border-b border-primary/20 pb-4 mb-6">
                    <div class="flex items-center justify-between">
                        <h1 class="font-black text-2xl bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
                            Task Details
                        </h1>
                        <form method="dialog">
                            <button class="btn btn-circle btn-ghost hover:bg-error/10 hover:text-error transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>    

                <!-- Modal Content -->
                <form class="flex flex-row gap-6 h-full" @submit.prevent="submitTask">
                    <!-- Left Section -->
                    <div class="w-1/2 flex flex-col space-y-6">
                        <!-- Task Info -->
                        <div class="bg-gradient-to-r from-primary/5 to-secondary/5 rounded-2xl p-6 border border-primary/10">
                            <h2 class="font-bold text-2xl text-primary mb-3">{{ selectedTask?.title || 'No Task Selected' }}</h2>
                            <p class="text-base-content/80 leading-relaxed">{{ selectedTask?.description || 'No description available' }}</p>
                        </div>

                        <!-- Details Section -->
                        <div class="bg-base-100 rounded-2xl p-6 shadow-lg border border-base-300">
                            <h3 class="font-bold text-xl mb-6 text-primary">Task Details</h3>
                            
                            <div class="space-y-4">
                                <!-- Start Date -->
                                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-info/10 to-info/5 rounded-xl border border-info/20">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-info/20 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-info" viewBox="0 -960 960 960" fill="currentColor">
                                                <path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Z"/>
                                            </svg>
                                        </div>
                                        <span class="font-semibold text-info">Start Date</span>
                                    </div>
                                    <span class="font-bold text-base-content">{{ formatDate(selectedTask?.start_date) }}</span>
                                </div>

                                <!-- Due Date -->
                                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-warning/10 to-warning/5 rounded-xl border border-warning/20">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-warning/20 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-warning" viewBox="0 -960 960 960" fill="currentColor">
                                                <path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Z"/>
                                            </svg>
                                        </div>
                                        <span class="font-semibold text-warning">Due Date</span>
                                    </div>
                                    <span class="font-bold text-base-content">{{ formatDate(selectedTask?.due_date) }}</span>
                                </div>

                                <!-- Status -->
                                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-neutral/10 to-neutral/5 rounded-xl border border-neutral/20">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-neutral/20 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-neutral" viewBox="0 -960 960 960" fill="currentColor">
                                                <path d="M480-120q-33 0-56.5-23.5T400-200q0-33 23.5-56.5T480-280q33 0 56.5 23.5T560-200q0 33-23.5 56.5T480-120Zm-80-240v-480h160v480H400Z"/>
                                            </svg>
                                        </div>
                                        <span class="font-semibold text-neutral">Status</span>
                                    </div>
                                    <div :class="getStatusBadgeClass(selectedTask?.status)">
                                        {{ selectedTask?.status || 'Not Started' }}
                                    </div>
                                </div>

                                <!-- Project Info -->
                                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-secondary/10 to-secondary/5 rounded-xl border border-secondary/20">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-secondary/20 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-secondary" viewBox="0 -960 960 960" fill="currentColor">
                                                <path d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/>
                                            </svg>
                                        </div>
                                        <span class="font-semibold text-secondary">Project</span>
                                    </div>
                                    <span class="font-bold text-base-content">{{ selectedTask?.project_name || 'Unknown Project' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="w-1/2 flex flex-col space-y-6">
                        <div class="bg-base-100 rounded-2xl p-6 shadow-lg border border-base-300 flex-1 flex flex-col justify-center items-center">
                            <div class="text-center mb-8">
                                <div class="w-24 h-24 bg-success/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-12 h-12 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-xl mb-2 text-success">
                                    Mark Task as Complete
                                </h3>
                                <p class="text-base-content/70">
                                    Click the button below to mark this task as completed.
                                </p>
                            </div>
                            
                            <!-- Submit Button -->
                            <button 
                                type="submit" 
                                class="btn w-full bg-gradient-to-r from-success to-success/80 hover:from-success/90 hover:to-success/70 text-success-content border-none shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02] font-bold text-lg py-4 rounded-2xl"
                                :disabled="isSubmitting"
                            >
                                <svg v-if="!isSubmitting" class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span v-if="isSubmitting" class="loading loading-spinner loading-sm mr-2"></span>
                                {{ isSubmitting ? 'Submitting...' : 'Mark as Complete' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </dialog>

        <!-- Enhanced Task Table -->
        <div class="bg-base-100 rounded-3xl shadow-2xl border border-primary/10 overflow-hidden">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-error/10 to-error/5 border-b border-error/20 p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-error/20 rounded-xl">
                            <svg class="w-8 h-8 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-black text-3xl text-error tracking-wide">{{ currentUser.f_name }}'s Tasks</h2>
                        </div>
                    </div>
                    
                    <!-- Filter Controls -->
                    <div class="flex gap-3">
                        <select v-model="statusFilter" @change="fetchTasks" class="select select-bordered select-sm">
                            <option value="">All Status</option>
                            <option value="Not Started">Not Started</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Near Deadline">Near Deadline</option>
                            <option value="Done">Done</option>
                            <option value="Submitted Late">Submitted Late</option>
                            <option value="Missed">Missed</option>
                        </select>
                        <select v-model="sortOrder" @change="fetchTasks" class="select select-bordered select-sm">
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>
                        <button @click="fetchTasks" class="btn btn-sm btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div v-if="loading" class="flex justify-center items-center py-12">
                <span class="loading loading-spinner loading-lg text-primary"></span>
            </div>

            <!-- Table Content -->
            <div v-else class="overflow-x-hidden">
                <table class="table w-full">
                    <thead>
                        <tr class="border-none bg-base-200/30">
                            <th class="py-6 px-8 font-bold text-lg text-base-content/80">Task Name</th>
                            <th class="py-6 font-bold text-lg text-base-content/80">Start Date</th>
                            <th class="py-6 font-bold text-lg text-base-content/80">Due Date</th>
                            <th class="py-6 font-bold text-lg text-base-content/80">Status</th>
                            <th class="py-6 font-bold text-lg text-base-content/80">Project</th>
                            <th class="py-6 font-bold text-lg text-base-content/80">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="tasks.length === 0">
                            <td colspan="6" class="text-center py-8 text-base-content/60">
                                No tasks found matching your criteria
                            </td>
                        </tr>
                        <tr 
                            v-for="task in tasks"
                            :key="task.task_id"
                            class="border-base-300/50 hover:bg-gradient-to-r hover:from-primary/5 hover:to-secondary/5 cursor-pointer transition-all duration-300 hover:shadow-lg group"
                        >
                            <td class="py-6 px-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-2 h-12 bg-gradient-to-b from-primary to-secondary rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <div>
                                        <div class="font-bold text-lg group-hover:text-primary transition-colors duration-300">
                                            {{ task.title }}
                                        </div>
                                        <div class="text-sm text-base-content/60 truncate max-w-xs">
                                            {{ task.description }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-6">
                                <span class="font-medium">{{ formatDate(task.start_date) }}</span>
                            </td>
                            <td class="py-6">
                                <div class="flex items-center gap-2">
                                    <div v-if="isDueSoon(task.due_date)" class="w-3 h-3 bg-error rounded-full animate-pulse"></div>
                                    <span :class="getDueDateClass(task.due_date)">
                                        {{ formatDate(task.due_date) }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-6">
                                <div :class="getStatusBadgeClass(task.status)">
                                    {{ getStatusIcon(task.status) }} {{ task.status }}
                                </div>
                            </td>
                            <td class="py-6">
                                <div class="font-semibold text-base-content bg-base-200 px-4 py-2 rounded-xl">
                                    {{ task.project_name }}
                                </div>
                            </td>
                            <td class="py-6">
                                <div class="flex gap-2">
                                    <button 
                                        @click="openModal(task)"
                                        class="btn btn-sm btn-primary"
                                        title="View Details"
                                        :disabled="submittedTasks.includes(task.task_id) || task.status === 'Done' || task.status === 'Submitted Late' || task.status === 'Missed'"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "TaskByDeadline",
    data() {
        return {
            tasks: [],
            selectedTask: null,
            loading: false,
            isSubmitting: false,
            statusFilter: '',
            sortOrder: 'asc',
            currentUser: {
                user_id: null,
                f_name: '',
                l_name: '',
                email: '',
                created_at: '',
            },
            submittedTasks: [],
        };
    },
    computed: {
        isTaskOwner() {
            return this.selectedTask?.owner_id === this.currentUser.user_id;
        }
    },
    async mounted() {
        await this.getCurrentUser();
        this.fetchTasks();
        this.setupAutoStatusUpdates();
    },
    methods: {
        async getCurrentUser() {
            try {
                const user = JSON.parse(localStorage.getItem('user'));
                if (user) {
                    this.currentUser = {
                        user_id: user.id,
                        f_name: user.f_name,
                        l_name: user.l_name,
                        email: user.email,
                        created_at: user.created_at
                    };
                } else {
                    console.error('Failed to get current user');
                }
            } catch (error) {
                console.error('Error getting current user:', error);
            }
        },

        async fetchTasks() {
            if (!this.currentUser.user_id) return;
            
            this.loading = true;
            try {
                const res = await axios.get('https://act-track.x10.mx/index.php/fetch-user-tasks', {
                    params: {
                        user_id: this.currentUser.user_id,
                        status_filter: this.statusFilter,
                        sort_order: this.sortOrder
                    }
                });
                
                if (res.data.success) {
                    // Update statuses immediately and get the updated tasks
                    this.tasks = await Promise.all(res.data.data.map(async task => {
                        const newStatus = await this.determineTaskStatus(task);
                        return {...task, status: newStatus};
                    }));
                } else {
                    console.error('Failed to fetch tasks:', res.data.message);
                }
            } catch (error) {
                console.error('Error fetching tasks:', error);
            } finally {
                this.loading = false;
            }
        },
        filterTasks(tasks) {
            let filtered = [...tasks];
            
            // Apply status filter if set
            if (this.statusFilter) {
                filtered = filtered.filter(task => task.status === this.statusFilter);
            }
            
            // Apply search query if set
            if (this.searchQuery) {
                const query = this.searchQuery.toLowerCase();
                filtered = filtered.filter(task => 
                    task.title.toLowerCase().includes(query) ||
                    task.description.toLowerCase().includes(query) ||
                    task.project_name.toLowerCase().includes(query)
                );
            }
            
            // Apply sorting
            filtered.sort((a, b) => {
                const dateA = new Date(a.due_date);
                const dateB = new Date(b.due_date);
                return this.sortOrder === 'asc' ? dateA - dateB : dateB - dateA;
            });
            
            return filtered;
        },

        onSearchInput() {
            if (this.originalTasks.length > 0) {
                this.tasks = this.filterTasks(this.originalTasks);
            }
        },

        setupAutoStatusUpdates() {
            // Update statuses every hour
            setInterval(async () => {
                this.tasks = await Promise.all(this.tasks.map(async task => {
                    const newStatus = await this.determineTaskStatus(task);
                    return { ...task, status: newStatus };
                }));
            }, 3600000); // 1 hour
        },

        async determineTaskStatus(task) {
            const now = new Date();
            const dueDate = new Date(task.due_date);
            const startDate = new Date(task.start_date);
            
            // If task is already done, don't change status
            if (task.status === 'Done' || task.status === 'Submitted Late' || task.status === 'Missed') {
                return task.status;
            }
            
            let newStatus = task.status;
            
            // Check if task is missed
            if (now > dueDate) {
                newStatus = 'Missed';
            }
            // Check if task is near deadline (within 24 hours)
            else if ((dueDate - now) / (1000 * 60 * 60) <= 24 && task.status !== 'Near Deadline') {
                newStatus = 'Near Deadline';
            }
            // Check if task is in progress (start date has passed)
            else if (now >= startDate && task.status === 'Not Started') {
                newStatus = 'In Progress';
            }
            
            // If status changed, update in database
            if (newStatus !== task.status) {
                await this.updateTaskStatus(task.task_id, this.currentUser.user_id, newStatus);
            }
            
            return newStatus;
        },

        async submitTask() {
            if (!this.selectedTask) return;
            
            this.isSubmitting = true;
            try {
                let newStatus = 'Done';
                const now = new Date();
                const dueDate = new Date(this.selectedTask.due_date);
                
                // Check if submission is late
                if (now > dueDate) {
                    newStatus = 'Submitted Late';
                }
                
                // Update task status
                await this.updateTaskStatus(
                    this.selectedTask.task_id, 
                    this.currentUser.user_id, 
                    newStatus
                );
                
                // Add to submitted tasks array
                this.submittedTasks.push(this.selectedTask.task_id);

                // If user is not the task owner, send notification to owner
                if (!this.isTaskOwner) {
                    await this.sendNotification(
                        this.selectedTask.owner_id,
                        'task_submitted',
                        `${this.currentUser.f_name} has marked task "${this.selectedTask.title}" as complete`,
                        this.selectedTask.task_id
                    );
                }
                
                // Close modal
                document.getElementById('my_modal_4').close();
                this.fetchTasks();
                
            } catch (error) {
                console.error('Error submitting task:', error);
                alert('Failed to submit task: ' + error.message);
            } finally {
                this.isSubmitting = false;
            }
        },

        async updateTaskStatus(taskId, userId, newStatus) {
            try {

                const payload = {
                    task_id: Number(taskId),
                    user_id: Number(userId),
                    status: String(newStatus).trim()
                };

                console.log("Sending payload:", payload); // Debug log

                const res = await axios.post(
                    'https://act-track.x10.mx/index.php/update-task-status', 
                    payload, // Stringify the payload
                    {
                        headers: {
                            'Content-Type': 'application/json' // Set proper header
                        }
                    }
                );
                
                  console.log("Response received:", res.data); // Log successful respons

                if (res.data.success) {
                    // Update local state
                    const taskIndex = this.tasks.findIndex(t => t.task_id === taskId);
                    if (taskIndex !== -1) {
                        this.tasks[taskIndex].status = newStatus;
                        if (this.tasks[taskIndex].user_status) {
                            this.tasks[taskIndex].user_status = newStatus;
                        }
                    }
                    
                    if (this.selectedTask && this.selectedTask.task_id === taskId) {
                        this.selectedTask.status = newStatus;
                        if (this.selectedTask.user_status) {
                            this.selectedTask.user_status = newStatus;
                        }
                    }
                    
                    return true;
                }
                return false;
            } catch (error) {
                console.error('Error updating task status:', error);
                return false;
            }
        },

        async sendNotification(userId, type, message, relatedId = null) {
            try {
                await axios.post('https://act-track.x10.mx/index.php/send-notification', {
                    user_id: userId,
                    type: type,
                    message: message,
                    related_id: relatedId
                });
            } catch (error) {
                console.error('Error sending notification:', error);
                console.error('Error details:', error.response?.data);
            }
        },

        openModal(task = null) {
            this.selectedTask = task;
            document.getElementById('my_modal_4').showModal();
        },

        formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
        },

        isDueSoon(dueDate) {
            if (!dueDate) return false;
            const today = new Date();
            const due = new Date(dueDate);
            const diffTime = due - today;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays <= 1 && diffDays >= 0;
        },

        getDueDateClass(dueDate) {
            if (this.isDueSoon(dueDate)) {
                return 'font-bold text-error';
            }
            return 'font-medium';
        },

        getStatusBadgeClass(status) {
            const baseClass = 'badge badge-lg font-bold px-4 py-2';
            switch (status) {
                case 'Not Started':
                    return `${baseClass} bg-gradient-to-r from-neutral/20 to-neutral/10 text-neutral border-neutral/30`;
                case 'In Progress':
                    return `${baseClass} bg-gradient-to-r from-info/20 to-info/10 text-info border-info/30`;
                case 'Near Deadline':
                    return `${baseClass} bg-gradient-to-r from-warning/20 to-warning/10 text-warning border-warning/30`;
                case 'Done':
                    return `${baseClass} bg-gradient-to-r from-success/20 to-success/10 text-success border-success/30`;
                case 'Submitted Late':
                    return `${baseClass} bg-gradient-to-r from-orange-500/20 to-orange-500/10 text-orange-500 border-orange-500/30`;
                case 'Missed':
                    return `${baseClass} bg-gradient-to-r from-error/20 to-error/10 text-error border-error/30`;
                default:
                    return `${baseClass} bg-gradient-to-r from-neutral/20 to-neutral/10 text-neutral border-neutral/30`;
            }
        },

        getStatusIcon(status) {
            switch (status) {
                case 'Not Started':
                    return '⏸️';
                case 'In Progress':
                    return '🔄';
                case 'Near Deadline':
                    return '⚠️';
                case 'Done':
                    return '✅';
                case 'Submitted Late':
                    return '⏰';
                case 'Missed':
                    return '❌';
                default:
                    return '📋';
            }
        }
    }
};
</script>

<style scoped>
/* Custom scrollbar for image gallery */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: transparent;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: rgba(156, 163, 175, 0.3);
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: rgba(156, 163, 175, 0.5);
}

/* Smooth transitions for all interactive elements */
* {
    transition: all 0.2s ease-in-out;
}

/* Enhanced button hover effects */
.btn:hover {
    transform: translateY(-1px);
}

/* Custom badge animations */
.badge {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.badge:hover {
    transform: scale(1.05);
}

/* Loading spinner custom colors */
.loading-spinner {
    border-top-color: currentColor;
}

/* Modal backdrop blur effect */
.modal {
    backdrop-filter: blur(8px);
}

/* Enhanced table row animations */
.table tbody tr {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.table tbody tr:hover {
    transform: translateX(4px);
}

/* Status indicator pulse animation */
@keyframes pulse-glow {
    0%, 100% {
        opacity: 1;
        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
    }
    50% {
        opacity: 0.7;
        box-shadow: 0 0 0 8px rgba(239, 68, 68, 0);
    }
}

.animate-pulse {
    animation: pulse-glow 2s infinite;
}

/* Gradient text animation */
@keyframes gradient-shift {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

.bg-gradient-to-r.bg-clip-text {
    background-size: 200% 200%;
    animation: gradient-shift 3s ease infinite;
}

/* Enhanced modal entrance animation */
.modal-box {
    animation: modalSlideIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Responsive design improvements */
@media (max-width: 768px) {
    .modal-box {
        width: 95%;
        max-width: 95%;
        height: 90%;
        max-height: 90%;
    }
    
    .flex-row {
        flex-direction: column;
    }
    
    .w-1\/2 {
        width: 100%;
    }
    
    .table {
        font-size: 0.875rem;
    }
    
    .py-6 {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }
    
    .px-8 {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}

/* Enhanced accessibility */
.btn:focus,
.select:focus,
input:focus {
    outline: 2px solid rgba(139, 92, 246, 0.6);
    outline-offset: 2px;
}

/* Print styles */
@media print {
    .modal,
    .btn,
    .loading {
        display: none !important;
    }
    
    .table {
        font-size: 12px;
    }
    
    .bg-gradient-to-r {
        background: #374151 !important;
        color: white !important;
    }
}

.btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none !important;
}
</style>