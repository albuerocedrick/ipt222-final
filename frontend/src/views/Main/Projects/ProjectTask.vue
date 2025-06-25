<template>
    <div class="h-full bg-base-100 flex flex-col overflow-hidden rounded-3xl shadow-2xl border border-primary/10">
        <!-- Project Header -->
        <div class="bg-gradient-to-r from-primary/10 to-secondary/10 border-b border-primary/20 p-6 rounded-t-3xl flex-shrink-0">
            <div v-if="selectedProject" class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-r from-primary to-secondary flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-xl">
                            {{ getProjectInitials(selectedProject.project_name) }}
                        </span>
                    </div>
                    <div>
                        <h1 class="font-black text-3xl text-primary tracking-wide">{{ selectedProject.project_name }}</h1>
                        <p class="text-base-content/60 text-sm">{{ selectedProject.description || 'No description available' }}</p>
                    </div>
                </div>
                
                <div class="flex gap-2">
                    <button v-if="canEditProject" @click="editProject" class="btn btn-warning hover:shadow-lg hover:scale-[1.02] transition-all duration-300 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" fill="currentColor">
                            <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                        </svg>
                        Edit
                    </button>
                    <button v-if="canDeleteProject" @click="deleteProject" class="btn btn-error hover:shadow-lg hover:scale-[1.02] transition-all duration-300 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" fill="currentColor">
                            <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/>
                        </svg>
                        Delete
                    </button>
                </div>
            </div>
            
            <!-- Empty State -->
            <div v-else class="text-center py-8 h-full">
                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-3xl flex items-center justify-center">
                    <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-primary mb-2">Select a Project</h3>
                <p class="text-base-content/60">Choose a project from the list to view its tasks and members</p>
            </div>
        </div>

        <!-- Content Area -->
        <div v-if="selectedProject" class="flex-1 flex flex-row min-h-0">
            <!-- Members Section -->
            <div class="w-2/5 border-r border-primary/20 flex flex-col">
                <!-- Members Header -->
                <div class="p-6 border-b border-primary/20 flex-shrink-0">
                    <div class="flex items-center justify-between">
                        <h2 class="font-bold text-2xl text-primary">Members</h2>
                        <button v-if="canManageMembers" @click="openAddMemberModal" class="btn btn-secondary hover:shadow-lg hover:scale-[1.02] transition-all duration-300 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" fill="currentColor">
                                <path d="M720-400v-120H600v-80h120v-120h80v120h120v80H800v120h-80Zm-360-80q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm80-80h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0-80Zm0 400Z"/>
                            </svg>
                            Add Member
                        </button>
                    </div>
                </div>

                <!-- Members List -->
                <div class="flex-1 overflow-y-auto p-6">
                    <div v-if="loadingMembers" class="flex justify-center items-center h-32">
                        <div class="flex items-center gap-3">
                            <span class="loading loading-spinner loading-lg text-primary"></span>
                            <span class="text-base-content/60 font-medium">Loading members...</span>
                        </div>
                    </div>
                    
                    <div v-else-if="members.length === 0" class="text-center py-8">
                        <div class="p-6 bg-gradient-to-br from-base-200/50 to-base-300/30 rounded-2xl border border-primary/10">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-2xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-primary mb-2">No Members Yet</h3>
                            <p class="text-base-content/60 text-sm">Add team members to collaborate on this project</p>
                        </div>
                    </div>

                    <div v-else class="space-y-3">
                        <div v-for="member in members" :key="member.user_id" 
                             class="bg-gradient-to-r from-base-200/50 to-base-300/30 rounded-xl p-4 border border-primary/10 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-primary to-secondary flex items-center justify-center text-white font-bold">
                                        {{ getUserInitials(member.f_name, member.l_name) }}
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-base-content">{{ member.f_name }} {{ member.l_name }}</h4>
                                        <p class="text-sm text-base-content/60">{{ member.email }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <span v-if="member.is_owner" class="px-2 py-1 bg-gradient-to-r from-primary to-primary/80 text-white rounded-full text-xs font-semibold">Owner</span>
                                    <span v-else class="px-2 py-1 bg-base-300 text-base-content/70 rounded-full text-xs font-semibold">Member</span>
                                    
                                    <div v-if="canManageMembers && !member.is_owner" class="dropdown dropdown-end">
                                        <div tabindex="0" role="button" class="btn btn-ghost btn-sm rounded-lg hover:bg-primary/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </div>
                                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-2xl bg-base-100 rounded-xl w-48 border border-primary/20">
                                            <li><a @click="removeMember(member)" class="text-error rounded-lg hover:bg-error/10">Remove Member</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- <div v-if="member.total_tasks > 0" class="mt-3">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-500">Personal Progress</span>
                                    <span class="font-medium">
                                        {{ member.completed_tasks }}/{{ member.total_tasks }} ({{ member.completion_percentage }}%)
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full" 
                                        :class="member.progress_color"
                                        :style="{ width: member.completion_percentage + '%' }">
                                    </div>
                                </div>
                            </div>
                            <div v-else class="mt-3 text-xs text-gray-500">
                                No assigned tasks
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks Section -->
            <div class="w-3/5 flex flex-col">
                <!-- Tasks Header -->
                <div class="p-6 border-b border-primary/20 flex-shrink-0">
                    <div class="flex items-center justify-between">
                        <h2 class="font-bold text-2xl text-primary">Tasks</h2>
                        <button v-if="canManageTasks" @click="openAddTaskModal" class="btn btn-secondary hover:shadow-lg hover:scale-[1.02] transition-all duration-300 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" height="28px" viewBox="0 -960 960 960" fill="currentColor">
                                <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/>
                            </svg>
                            Add Task
                        </button>
                    </div>
                </div>

                <!-- Tasks List -->
                <div class="flex-1 overflow-y-auto p-6">
                    <div v-if="loadingTasks" class="flex justify-center items-center h-32">
                        <div class="flex items-center gap-3">
                            <span class="loading loading-spinner loading-lg text-primary"></span>
                            <span class="text-base-content/60 font-medium">Loading tasks...</span>
                        </div>
                    </div>
                    
                    <div v-else-if="tasks.length === 0" class="text-center py-12">
                        <div class="p-6 bg-gradient-to-br from-base-200/50 to-base-300/30 rounded-2xl border border-primary/10 max-w-md mx-auto">
                            <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-2xl flex items-center justify-center">
                                <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-primary mb-2">No Tasks Yet</h3>
                            <p class="text-base-content/60 mb-6">Create your first task to start organizing your project!</p>
                            <button v-if="canManageTasks" @click="openAddTaskModal" class="btn btn-primary rounded-xl hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create Task
                            </button>
                        </div>
                    </div>

                    <div v-else class="space-y-4">
                        <div v-for="task in tasks" :key="task.task_id" 
                             class="bg-gradient-to-r from-base-200/50 to-base-300/30 rounded-2xl p-6 border border-primary/10 hover:shadow-xl hover:scale-[1.01] transition-all duration-300">
                            
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="font-bold text-xl text-primary mb-2">{{ task.title }}</h3>
                                    <p class="text-base-content/70 text-sm mb-4">{{ task.description }}</p>
                                    
                                    <div class="flex items-center gap-4 text-sm">
                                        <!-- <div class="flex items-center gap-2">
                                            <span class="text-base-content/60">Status:</span>
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold" :class="getStatusBadgeClass(task.status)">
                                                {{ task.status }}
                                            </span>
                                        </div> -->
                                        <div v-if="task.due_date" class="flex items-center gap-2">
                                            <span class="text-base-content/60">Due:</span>
                                            <span class="font-medium" :class="getDueDateClass(task.due_date)">
                                                {{ formatDate(task.due_date) }}
                                            </span>
                                        </div>
                                        <div v-if="task.is_individual" class="flex items-center gap-2">
                                            <span class="text-base-content/60">Type:</span>
                                            <span class="font-medium">Individual</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div v-if="canManageTasks" class="dropdown dropdown-end">
                                    <div tabindex="0" role="button" class="btn btn-ghost btn-sm rounded-lg hover:bg-primary/10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                        </svg>
                                    </div>
                                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-2xl bg-base-100 rounded-xl w-48 border border-primary/20">
                                        <li><a @click="editTask(task)" class="rounded-lg hover:bg-primary/10">Edit Task</a></li>
                                        <li><a @click="deleteTask(task)" class="text-error rounded-lg hover:bg-error/10">Delete Task</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add/Edit Task Modal -->
        <dialog ref="addTaskModal" class="modal">
            <div class="modal-box bg-gradient-to-br from-base-100 to-base-200 rounded-3xl border border-primary/20 shadow-2xl max-w-lg">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-3 bg-primary/20 rounded-xl">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-2xl text-primary">
                        {{ newTask.task_id ? 'Edit Task' : 'Create New Task' }}
                    </h3>
                </div>
                
                <form @submit.prevent="newTask.task_id ? updateTask() : createTask()" class="space-y-4">
                    <div class="form-control flex flex-col">
                        <label class="label">
                            <span class="label-text font-semibold text-base-content/80">Task Title</span>
                        </label>
                        <input v-model="newTask.title" type="text" placeholder="Enter task title" 
                            class="input input-bordered rounded-xl border-primary/20 focus:border-primary focus:ring-2 focus:ring-primary/20 bg-base-200/50 w-full" required>
                    </div>
                    
                    <div class="form-control flex flex-col">
                        <label class="label">
                            <span class="label-text font-semibold text-base-content/80">Description</span>
                        </label>
                        <textarea v-model="newTask.description" class="w-full textarea textarea-bordered rounded-xl border-primary/20 focus:border-primary focus:ring-2 focus:ring-primary/20 bg-base-200/50" 
                                placeholder="Task description" rows="3"></textarea>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold text-base-content/80">Start Date</span>
                            </label>
                            <input v-model="newTask.start_date" type="date" 
                                class="input input-bordered rounded-xl border-primary/20 focus:border-primary focus:ring-2 focus:ring-primary/20 bg-base-200/50">
                        </div>
                        
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold text-base-content/80">Due Date</span>
                            </label>
                            <input v-model="newTask.due_date" type="date" 
                                class="input input-bordered rounded-xl border-primary/20 focus:border-primary focus:ring-2 focus:ring-primary/20 bg-base-200/50">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold text-base-content/80">Task Type</span>
                            </label>
                            <select v-model="newTask.is_individual" 
                                    class="select select-bordered rounded-xl border-primary/20 focus:border-primary focus:ring-2 focus:ring-primary/20 bg-base-200/50">
                                <option :value="false">Group Task</option>
                                <option :value="true">Individual Task</option>
                            </select>
                        </div>
                        
                        <div v-if="newTask.task_id" class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold text-base-content/80">Status</span>
                            </label>
                            <select v-model="newTask.status" 
                                    class="select select-bordered rounded-xl border-primary/20 focus:border-primary focus:ring-2 focus:ring-primary/20 bg-base-200/50">
                                <option value="Not Started">Not Started</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Near Deadline">Near Deadline</option>
                                <option value="Done">Done</option>
                                <option value="Submitted Late">Submitted Late</option>
                                <option value="Missed">Missed</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="modal-action gap-3 pt-4">
                        <button type="button" class="btn btn-ghost rounded-xl hover:bg-base-200/50 transition-all duration-200" @click="closeAddTaskModal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-xl hover:shadow-lg hover:scale-[1.02] transition-all duration-300" :disabled="!newTask.title.trim()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ newTask.task_id ? 'Update Task' : 'Create Task' }}
                        </button>
                    </div>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button @click="closeAddTaskModal">close</button>
            </form>
        </dialog>

        <!-- Add Member Modal -->
        <dialog ref="addMemberModal" class="modal">
            <div class="modal-box bg-gradient-to-br from-base-100 to-base-200 rounded-3xl border border-primary/20 shadow-2xl max-w-lg">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-3 bg-secondary/20 rounded-xl">
                        <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-2xl text-primary">Add Member</h3>
                </div>
                
                <form @submit.prevent="addMember" class="space-y-4">
                    <div class="form-control flex flex-col">
                        <label class="label">
                            <span class="label-text font-semibold text-base-content/80">Email Address</span>
                        </label>
                        <input v-model="newMember.email" type="email" placeholder="Enter member's email" 
                            class="w-full input input-bordered rounded-xl border-primary/20 focus:border-secondary focus:ring-2 focus:ring-secondary/20 bg-base-200/50" required>
                    </div>
                    
                    <div class="modal-action gap-3 pt-4">
                        <button type="button" class="btn btn-ghost rounded-xl hover:bg-base-200/50 transition-all duration-200" @click="closeAddMemberModal">Cancel</button>
                        <button type="submit" class="btn btn-secondary rounded-xl hover:shadow-lg hover:scale-[1.02] transition-all duration-300" :disabled="!newMember.email.trim()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Member
                        </button>
                    </div>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button @click="closeAddMemberModal">close</button>
            </form>
        </dialog>

        <!-- Edit Project Modal -->
        <dialog ref="editProjectModal" class="modal">
            <div class="modal-box bg-gradient-to-br from-base-100 to-base-200 rounded-3xl border border-primary/20 shadow-2xl max-w-lg">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-3 bg-warning/20 rounded-xl">
                        <svg class="w-6 h-6 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-2xl text-primary">Edit Project</h3>
                </div>
                
                <form @submit.prevent="updateProject" class="space-y-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-base-content/80">Project Name</span>
                        </label>
                        <input v-model="editingProject.project_name" type="text" placeholder="Enter project name" 
                            class="input input-bordered rounded-xl border-primary/20 focus:border-warning focus:ring-2 focus:ring-warning/20 bg-base-200/50" required>
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-base-content/80">Description</span>
                        </label>
                        <textarea v-model="editingProject.description" 
                                class="textarea textarea-bordered rounded-xl border-primary/20 focus:border-warning focus:ring-2 focus:ring-warning/20 bg-base-200/50" 
                                placeholder="Project description" rows="3"></textarea>
                    </div>
                    
                    <div class="modal-action gap-3 pt-4">
                        <button type="button" class="btn btn-ghost rounded-xl hover:bg-base-200/50 transition-all duration-200" @click="closeEditProjectModal">Cancel</button>
                        <button type="submit" class="btn btn-warning rounded-xl hover:shadow-lg hover:scale-[1.02] transition-all duration-300" :disabled="!editingProject.project_name.trim()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Update Project
                        </button>
                    </div>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button @click="closeEditProjectModal">close</button>
            </form>
        </dialog>

        <!-- Delete Project Confirmation Modal -->
        <dialog ref="deleteProjectModal" class="modal">
            <div class="modal-box bg-gradient-to-br from-base-100 to-base-200 rounded-3xl border border-error/20 shadow-2xl max-w-md">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-3 bg-error/20 rounded-xl">
                        <svg class="w-6 h-6 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-2xl text-error">Delete Project</h3>
                </div>
                
                <div class="space-y-4">
                    <div class="bg-error/10 border border-error/20 rounded-xl p-4">
                        <p class="text-base-content font-medium mb-2">Are you sure you want to delete this project?</p>
                        <p class="text-base-content/70 text-sm mb-3">
                            <strong class="text-error">{{ selectedProject?.project_name }}</strong>
                        </p>
                        <p class="text-base-content/60 text-sm">
                            This action cannot be undone. All tasks, members, and project data will be permanently deleted.
                        </p>
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-base-content/80">
                                Type <span class="text-error font-bold">DELETE</span> to confirm
                            </span>
                        </label>
                        <input v-model="deleteConfirmation" type="text" placeholder="Type DELETE" 
                            class="input input-bordered rounded-xl border-error/20 focus:border-error focus:ring-2 focus:ring-error/20 bg-base-200/50 w-full">
                    </div>
                </div>
                
                <div class="modal-action gap-3 pt-6">
                    <button type="button" class="btn btn-ghost rounded-xl hover:bg-base-200/50 transition-all duration-200" @click="closeDeleteProjectModal">Cancel</button>
                    <button @click="confirmDeleteProject" 
                            class="btn btn-error rounded-xl hover:shadow-lg hover:scale-[1.02] transition-all duration-300" 
                            :disabled="deleteConfirmation !== 'DELETE'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete Project
                    </button>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button @click="closeDeleteProjectModal">close</button>
            </form>
        </dialog>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            selectedProject: null,
            tasks: [],
            members: [],
            loadingTasks: false,
            loadingMembers: false,
            error: '',
            success: '',
            projectStats: {
                totalTasks: 0,
                completedTasks: 0
            },
            newTask: {
                title: '',
                description: '',
                start_date: '',
                due_date: '',
                status: 'Not Started',
                is_individual: false
            },
            newMember: {
                email: '',
            },
            editingProject: {
                project_id: null,
                project_name: '',
                description: '',
            },
            deleteConfirmation: ''
        }
    },
    
    computed: {
        canEditProject() {
            return this.selectedProject && (this.selectedProject.is_owner || this.selectedProject.permission_level === 'admin');
        },
        canDeleteProject() {
            return this.selectedProject && this.selectedProject.is_owner;
        },
        canManageMembers() {
            return this.selectedProject && (this.selectedProject.is_owner || this.selectedProject.permission_level === 'admin');
        },
        canManageTasks() {
            return this.selectedProject && (this.selectedProject.is_owner || this.selectedProject.permission_level === 'admin');
        }
    },
    
    mounted() {
        this.$bus.$on("FetchTasksByProj", this.fetchTasksByProject);
        this.$bus.$on("ProjectSelected", this.onProjectSelected);
        this.$bus.$on("ProjectDeleted", this.onProjectDeleted);
        this.$bus.$on("ProjectLeft", this.onProjectLeft);
    },
    
    beforeUnmount() {
        this.$bus.$off("FetchTasksByProj", this.fetchTasksByProject);
        this.$bus.$off("ProjectSelected", this.onProjectSelected);
        this.$bus.$off("ProjectDeleted", this.onProjectDeleted);
        this.$bus.$off("ProjectLeft", this.onProjectLeft);
    },
    
    methods: {
        async fetchTasksByProject(projectId) {
            this.loadingTasks = true;
            try {
                const res = await axios.get('https://act-track.x10.mx/index.php/fetchtaskbyprojid', {
                    params: { project_id: projectId }
                });

                if (res.data.success) {
                    this.tasks = res.data.data;
                } else {
                    this.handleError('Failed to load tasks');
                }
            } catch (error) {
                this.handleError('Something went wrong during task fetch');
            } finally {
                this.loadingTasks = false;
            }
        },
        
        async fetchProjectMembers(projectId) {
            this.loadingMembers = true;
            try {
                const res = await axios.get('https://act-track.x10.mx/index.php/fetch-project-members', {
                    params: { project_id: projectId }
                });

                if (res.data.success) {
                    this.members = res.data.data.map(member => {
                        // Calculate individual completion percentage
                        const total = member.total_tasks || 0;
                        const completed = member.completed_tasks || 0;
                        const percentage = total > 0 ? Math.round((completed / total) * 100) : 0;
                        
                        return {
                            ...member,
                            completion_percentage: percentage,
                            progress_color: this.getProgressColor(percentage)
                        };
                    });
                } else {
                    this.handleError('Failed to load members');
                }
            } catch (error) {
                console.error('Member fetch error:', error);
                this.handleError('Error loading members');
            } finally {
                this.loadingMembers = false;
            }
        },
        
        getProgressColor(percentage) {
            if (percentage >= 80) return 'bg-success';
            if (percentage >= 50) return 'bg-warning';
            return 'bg-error';
        },
        getCompletionPercentage() {
            if (this.projectStats.totalTasks === 0) return 0;
            return Math.round((this.projectStats.completedTasks / this.projectStats.totalTasks) * 100);
        },
        
        onProjectSelected(project) {
            this.selectedProject = project;
            this.fetchProjectMembers(project.project_id);
            this.fetchTasksByProject(project.project_id);
        },
        
        onProjectDeleted() {
            this.selectedProject = null;
            this.tasks = [];
            this.members = [];
        },
        
        onProjectLeft() {
            this.selectedProject = null;
            this.tasks = [];
            this.members = [];
        },
        
        getProjectInitials(name) {
            return name.split(' ')
                      .map(word => word.charAt(0))
                      .join('')
                      .toUpperCase()
                      .substring(0, 2);
        },
        
        getUserInitials(firstName, lastName) {
            return (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();
        },
        
        formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
        },
        
        getStatusBadgeClass(status) {
            const statusClasses = {
                'Not Started': 'bg-gray-500 text-white',
                'In Progress': 'bg-blue-500 text-white',
                'Near Deadline': 'bg-yellow-500 text-yellow-900',
                'Done': 'bg-green-500 text-white',
                'Submitted Late': 'bg-orange-500 text-white',
                'Missed': 'bg-red-500 text-white'
            };
            return statusClasses[status] || 'bg-gray-500 text-white';
        },
        
        getDueDateClass(dueDateString) {
            if (!dueDateString) return 'text-base-content';
            const dueDate = new Date(dueDateString);
            const today = new Date();
            const timeDiff = dueDate - today;
            const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
            
            if (daysDiff < 0) return 'text-red-500 font-bold';
            if (daysDiff <= 3) return 'text-orange-500 font-bold';
            if (daysDiff <= 7) return 'text-yellow-600 font-bold';
            return 'text-base-content';
        },
        
        // Task Methods
        openAddTaskModal() {
            this.newTask = {
                title: '',
                description: '',
                start_date: '',
                due_date: '',
                status: 'Not Started',
                is_individual: false
            };
            this.$refs.addTaskModal.showModal();
        },
        
        closeAddTaskModal() {
            this.$refs.addTaskModal.close();
        },
        
        editTask(task) {
            this.newTask = {
                task_id: task.task_id,
                title: task.title,
                description: task.description,
                start_date: task.start_date || '',
                due_date: task.due_date || '',
                status: task.status,
                is_individual: task.is_individual
            };
            this.$refs.addTaskModal.showModal();
        },

        async createTask() {
            try {
                const res = await axios.post('https://act-track.x10.mx/index.php/create-task-in-projects', {
                    project_id: this.selectedProject.project_id,
                    title: this.newTask.title,
                    description: this.newTask.description,
                    start_date: this.newTask.start_date || null,
                    due_date: this.newTask.due_date || null,
                    is_individual: this.newTask.is_individual
                });

                if (res.data.success) {
                    this.handleSuccess('Task created successfully!');
                    this.closeAddTaskModal();
                    await this.fetchTasksByProject(this.selectedProject.project_id);
                    await this.fetchProjectMembers(this.selectedProject.project_id); // Add this line
                } else {
                    this.handleError(res.data.message || 'Failed to create task');
                }
            } catch (error) {
                this.handleError('Error creating task');
            }
        },

        async updateTask() {
            try {
                const res = await axios.put('https://act-track.x10.mx/index.php/update-task-in-projects', {
                    task_id: this.newTask.task_id,
                    title: this.newTask.title,
                    description: this.newTask.description,
                    start_date: this.newTask.start_date || null,
                    due_date: this.newTask.due_date || null,
                    status: this.newTask.status,
                    is_individual: this.newTask.is_individual
                });

                if (res.data.success) {
                    this.handleSuccess('Task updated successfully!');
                    this.closeAddTaskModal();
                    this.fetchTasksByProject(this.selectedProject.project_id);
                } else {
                    this.handleError(res.data.message || 'Failed to update task');
                }
            } catch (error) {
                this.handleError('Error updating task');
            }
        },

        async deleteTask(task) {
            if (!confirm(`Are you sure you want to delete "${task.title}"?`)) {
                return;
            }

            try {
                const res = await axios.delete('https://act-track.x10.mx/index.php/delete-task', {
                    data: { task_id: task.task_id }
                });

                if (res.data.success) {
                    this.handleSuccess('Task deleted successfully!');
                    this.fetchTasksByProject(this.selectedProject.project_id);
                } else {
                    this.handleError(res.data.message || 'Failed to delete task');
                }
            } catch (error) {
                this.handleError('Error deleting task');
            }
        },

        // Member Methods
        openAddMemberModal() {
            this.newMember = {
                email: '',
            };
            this.$refs.addMemberModal.showModal();
        },

        closeAddMemberModal() {
            this.$refs.addMemberModal.close();
        },

        async addMember() {
            try {
                const res = await axios.post('https://act-track.x10.mx/index.php/add-member', {
                    project_id: this.selectedProject.project_id,
                    email: this.newMember.email,
                });

                if (res.data.success) {
                    this.handleSuccess('Member added successfully!');
                    this.closeAddMemberModal();
                    this.fetchProjectMembers(this.selectedProject.project_id);
                } 
                else {
                    this.handleError(res.data.message || 'Failed to add member');
                }
            } catch (error) {
                this.handleError('Error adding member');
            }
        },

        async removeMember(member) {
            if (!confirm(`Are you sure you want to remove ${member.f_name} ${member.l_name} from this project?`)) {
                return;
            }

            try {
                const res = await axios.delete('https://act-track.x10.mx/index.php/remove-member', {
                    data: {
                        project_id: this.selectedProject.project_id,
                        user_id: member.user_id
                    }
                });

                if (res.data.success) {
                    this.handleSuccess('Member removed successfully!');
                    this.fetchProjectMembers(this.selectedProject.project_id);
                } else {
                    this.handleError(res.data.message || 'Failed to remove member');
                }
            } catch (error) {
                this.handleError('Error removing member');
            }
        },

        // Project Methods
        editProject() {
            this.editingProject = {
                project_id: this.selectedProject.project_id,
                project_name: this.selectedProject.project_name,
                description: this.selectedProject.description || '',
            };
            this.$refs.editProjectModal.showModal();
        },

        closeEditProjectModal() {
            this.$refs.editProjectModal.close();
        },

        async updateProject() {
            try {
                const res = await axios.put('https://act-track.x10.mx/index.php/update-project', {
                    project_id: this.editingProject.project_id,
                    project_name: this.editingProject.project_name,
                    description: this.editingProject.description,
                });

                if (res.data.success) {
                    this.handleSuccess('Project updated successfully!');
                    this.closeEditProjectModal();
                    // Update the selected project with new data
                    this.selectedProject = {
                        ...this.selectedProject,
                        project_name: this.editingProject.project_name,
                        description: this.editingProject.description,
                    };
                    // Emit event to refresh project list
                    this.$bus.$emit("ProjectUpdated", this.selectedProject);
                } else {
                    this.handleError(res.data.message || 'Failed to update project');
                }
            } catch (error) {
                this.handleError('Error updating project');
            }
        },

        deleteProject() {
            this.deleteConfirmation = '';
            this.$refs.deleteProjectModal.showModal();
        },

        closeDeleteProjectModal() {
            this.deleteConfirmation = '';
            this.$refs.deleteProjectModal.close();
        },

        async confirmDeleteProject() {
            if (this.deleteConfirmation !== 'DELETE') {
                return;
            }

            try {
                const res = await axios.delete('https://act-track.x10.mx/index.php/delete-project', {
                    data: { project_id: this.selectedProject.project_id }
                });

                if (res.data.success) {
                    this.handleSuccess('Project deleted successfully!');
                    this.closeDeleteProjectModal();
                    this.$bus.$emit("ProjectDeleted");
                    this.selectedProject = null;
                    this.tasks = [];
                    this.members = [];
                } else {
                    this.handleError(res.data.message || 'Failed to delete project');
                }
            } catch (error) {
                this.handleError('Error deleting project');
            }
        },

        // Utility Methods
        currentUser() {
            const user = JSON.parse(localStorage.getItem('user'));
            return user.user_id;
        },

        handleSuccess(message) {
            this.success = message;
            this.error = '';
            // alert(this.success);
        },

        handleError(message) {
            this.error = message;
            this.success = '';
            // alert(this.error);
        }
    }
}
</script>

<style scoped>
/* Custom scrollbar styling */
.overflow-y-auto {
    scrollbar-width: thin;
    scrollbar-color: rgba(139, 92, 246, 0.2) transparent;
}

.overflow-y-auto::-webkit-scrollbar {
    width: 8px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: transparent;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background-color: rgba(139, 92, 246, 0.2);
    border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background-color: rgba(139, 92, 246, 0.4);
}

/* Status badge colors */
.bg-gray-500 { background-color: #6b7280; }
.bg-blue-500 { background-color: #3b82f6; }
.bg-yellow-500 { background-color: #eab308; }
.bg-green-500 { background-color: #22c55e; }
.bg-orange-500 { background-color: #f97316; }
.bg-red-500 { background-color: #ef4444; }

/* Text colors */
.text-yellow-600 { color: #ca8a04; }
.text-orange-500 { color: #f97316; }
.text-red-500 { color: #ef4444; }

/* Transition effects */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}

/* Hover effects */
.hover\:shadow-lg:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.hover\:scale-\[1\.02\]:hover {
    transform: scale(1.02);
}
</style>