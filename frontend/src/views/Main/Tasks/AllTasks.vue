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
                        <div class="bg-base-100 rounded-2xl p-6 shadow-lg border border-base-300 flex-1">
                            <h3 class="font-bold text-xl mb-4 text-secondary">Submit Task Proof</h3>
                            
                            <!-- Enhanced Drop Zone -->
                            <div
                                class="border-2 border-dashed border-secondary/30 rounded-2xl p-8 text-center hover:border-secondary/60 transition-all duration-300 cursor-pointer bg-gradient-to-br from-secondary/5 to-secondary/10 hover:from-secondary/10 hover:to-secondary/15 mb-6"
                                @click="triggerFileUpload"
                                @dragover.prevent="onDragOver"
                                @dragleave.prevent="onDragLeave"
                                @drop.prevent="onDrop"
                                :class="{'border-secondary bg-secondary/20 scale-[1.02]': isDragging}"
                            >
                                <div class="p-4 bg-secondary/10 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <p class="font-semibold text-secondary mb-2">Drop images here or click to browse</p>
                                <p class="text-sm text-base-content/60">PNG, JPG, GIF up to 10MB</p>
                                <input type="file" ref="fileInput" class="hidden" accept="image/*" multiple @change="onFileChange">
                            </div>

                            <!-- Image Gallery -->
                            <div class="max-h-48 overflow-y-auto rounded-xl bg-base-200/50 p-4" v-if="images.length > 0">
                                <div class="grid grid-cols-3 gap-3">
                                    <div
                                        v-for="(img, index) in images"
                                        :key="index"
                                        class="relative group"
                                    >
                                        <div class="aspect-square rounded-xl overflow-hidden bg-base-300 shadow-lg group-hover:shadow-xl transition-all duration-300">
                                            <img
                                                :src="img.src"
                                                :alt="img.name"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                            />
                                            <button
                                                type="button"
                                                class="absolute -top-2 -right-2 bg-error text-error-content rounded-full w-7 h-7 flex items-center justify-center shadow-lg hover:bg-error/80 transition-all duration-200 opacity-0 group-hover:opacity-100"
                                                @click="removeImage(index)"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="text-xs text-center mt-2 truncate font-medium" :title="img.name">
                                            {{ img.name }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button 
                                type="submit" 
                                class="btn w-full bg-gradient-to-r from-success to-success/80 hover:from-success/90 hover:to-success/70 text-success-content border-none shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02] font-bold text-lg py-4 rounded-2xl mt-6"
                                :disabled="images.length === 0 || isSubmitting"
                            >
                                <svg v-if="!isSubmitting" class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span v-if="isSubmitting" class="loading loading-spinner loading-sm mr-2"></span>
                                {{ isSubmitting ? 'Submitting...' : 'Submit Task' }}
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
                            <h2 class="font-black text-3xl text-error tracking-wide">Cedrick's Tasks</h2>
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
export default {
    name: "TaskByDeadline",
    data() {
        return {
            isDragging: false,
            images: [],
            tasks: [],
            selectedTask: null,
            loading: false,
            isSubmitting: false,
            statusFilter: '',
            sortOrder: 'asc', // 'asc' or 'desc'
            currentUser: {
                user_id: 1, // This should come from authentication
                f_name: 'John',
                l_name: 'Doe'
            }
        };
    },
    mounted() {
        this.fetchTasks();
    },
    methods: {
        async fetchTasks() {
            this.loading = true;
            try {
                // Simulate API call - replace with actual API endpoint
                const response = await this.mockFetchTasks();
                this.tasks = response;
            } catch (error) {
                console.error('Error fetching tasks:', error);
                // You could show a toast notification here
            } finally {
                this.loading = false;
            }
        },

        // Mock API call - replace with actual API integration
        async mockFetchTasks() {
            // Simulate API delay
            await new Promise(resolve => setTimeout(resolve, 500));
            
            // Mock data matching your database schema
            let tasks = [
                {
                    task_id: 1,
                    project_id: 1,
                    title: 'Create a Dashboard for IPT',
                    description: 'Create a dashboard for IPT. Add some analytics and other stuffs',
                    status: 'Near Deadline',
                    start_date: '2024-10-01',
                    due_date: '2024-10-17',
                    project_name: 'IPT222 - ActTrack',
                    created_at: '2024-09-15 10:00:00'
                },
                {
                    task_id: 2,
                    project_id: 1,
                    title: 'Database Design and Setup',
                    description: 'Design and implement the database schema for the task management system',
                    status: 'In Progress',
                    start_date: '2024-10-05',
                    due_date: '2024-10-20',
                    project_name: 'IPT222 - ActTrack',
                    created_at: '2024-09-20 14:30:00'
                },
                {
                    task_id: 3,
                    project_id: 2,
                    title: 'User Authentication Module',
                    description: 'Implement user registration, login, and authentication features',
                    status: 'Not Started',
                    start_date: '2024-10-10',
                    due_date: '2024-10-25',
                    project_name: 'Web Development Project',
                    created_at: '2024-09-25 09:15:00'
                }
            ];
            
            // Apply status filter
            if (this.statusFilter) {
                tasks = tasks.filter(task => task.status === this.statusFilter);
            }
            
            // Apply sorting
            tasks.sort((a, b) => {
                const dateA = new Date(a.due_date);
                const dateB = new Date(b.due_date);
                return this.sortOrder === 'asc' ? dateA - dateB : dateB - dateA;
            });
            
            return tasks;
        },

        openModal(task = null) {
            this.selectedTask = task;
            this.images = []; // Reset images when opening modal
            document.getElementById('my_modal_4').showModal();
        },

        async submitTask() {
            if (!this.selectedTask || this.images.length === 0) return;
            
            this.isSubmitting = true;
            try {
                // Create form data for file upload
                const formData = new FormData();
                formData.append('task_id', this.selectedTask.task_id);
                formData.append('submitted_by', this.currentUser.user_id);
                
                // Add each image to form data
                this.images.forEach((image, index) => {
                    formData.append(`photos[${index}]`, image.file);
                });

                // Simulate API call - replace with actual submission
                await this.mockSubmitTask(formData);
                
                // Update task status to Done
                await this.updateTaskStatus(this.selectedTask.task_id, 'Done');
                
                // Reset form and close modal
                this.images = [];
                document.getElementById('my_modal_4').close();
                
                // Show success message (you could use a toast library)
                alert('Task submitted successfully!');
                
            } catch (error) {
                console.error('Error submitting task:', error);
                alert('Error submitting task. Please try again.');
            } finally {
                this.isSubmitting = false;
            }
        },

        async mockSubmitTask(formData) {
            // Simulate API delay
            await new Promise(resolve => setTimeout(resolve, 1000));
            
            // In real implementation, this would make a POST request to your API
            console.log('Submitting task with images:', formData);
            return { success: true, submission_id: Date.now() };
        },

        async updateTaskStatus(taskId, newStatus) {
            try {
                // Simulate API call - replace with actual API endpoint
                await this.mockUpdateTaskStatus(taskId, newStatus);
                
                // Update local state
                const taskIndex = this.tasks.findIndex(t => t.task_id === taskId);
                if (taskIndex !== -1) {
                    this.tasks[taskIndex].status = newStatus;
                }
                
                // Update selected task if it's the same
                if (this.selectedTask && this.selectedTask.task_id === taskId) {
                    this.selectedTask.status = newStatus;
                }
                
            } catch (error) {
                console.error('Error updating task status:', error);
            }
        },

        async mockUpdateTaskStatus(taskId, newStatus) {
            // Simulate API delay
            await new Promise(resolve => setTimeout(resolve, 300));
            console.log(`Updating task ${taskId} status to ${newStatus}`);
            return { success: true };
        },

        triggerFileUpload() {
            this.$refs.fileInput.click();
        },

        onFileChange(e) {
            const files = Array.from(e.target.files);
            this.handleFiles(files);
        },

        onDragOver() {
            this.isDragging = true;
        },

        onDragLeave() {
            this.isDragging = false;
        },

        onDrop(e) {
            this.isDragging = false;
            const files = Array.from(e.dataTransfer.files);
            this.handleFiles(files);
        },

        handleFiles(files) {
            files.forEach((file) => {
                if (file.type.startsWith("image/") && file.size <= 10 * 1024 * 1024) { // 10MB limit
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.images.push({ 
                            src: e.target.result, 
                            name: file.name,
                            file: file 
                        });
                    };
                    reader.readAsDataURL(file);
                } else {
                    alert(`File ${file.name} is either not an image or exceeds 10MB limit`);
                }
            });
        },

        removeImage(index) {
            this.images.splice(index, 1);
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
            return diffDays <= 1 && diffDays >= 0; // Due today or tomorrow
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

/* Custom file input styling */
input[type="file"] {
    opacity: 0;
    position: absolute;
    pointer-events: none;
}

/* Image gallery animations */
.aspect-square img {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
</style>