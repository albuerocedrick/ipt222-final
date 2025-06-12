<template>
    <div class="h-full bg-base-100 flex flex-col overflow-hidden rounded-3xl shadow-2xl border border-primary/10">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-primary/10 to-secondary/10 border-b border-primary/20 p-6 rounded-t-3xl flex-shrink-0 flex flex-row items-center">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-primary/20 rounded-xl">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-black text-3xl text-primary tracking-wide">Projects</h1>
                        <p class="text-base-content/60 text-sm">Manage your project workspace</p>
                    </div>
                </div>
                
                <div class="ml-3 flex gap-3 items-center">
                    <!-- Sort Dropdown -->
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="group btn btn-ghost btn-sm bg-base-200/50 hover:bg-primary/10 hover:shadow-md transition-all duration-300 rounded-xl border border-primary/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                            </svg>
                            <span class="font-semibold text-primary">Sort</span>
                        </div>
                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-2xl bg-base-100 rounded-2xl w-52 border border-primary/20">
                            <li><a @click="sortProjects('name_asc')" class="rounded-xl hover:bg-primary/10 transition-all duration-200">Name (A-Z)</a></li>
                            <li><a @click="sortProjects('name_desc')" class="rounded-xl hover:bg-primary/10 transition-all duration-200">Name (Z-A)</a></li>
                            <li><a @click="sortProjects('date_asc')" class="rounded-xl hover:bg-primary/10 transition-all duration-200">Oldest First</a></li>
                            <li><a @click="sortProjects('date_desc')" class="rounded-xl hover:bg-primary/10 transition-all duration-200">Newest First</a></li>
                        </ul>
                    </div>
                    
                    <!-- Add Project Button -->
                    <button @click="openAddProjectModal" class="group btn btn-primary rounded-xl hover:shadow-lg hover:scale-[1.02] transition-all duration-300 border-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Projects List -->
        <div class="flex-1 overflow-y-auto p-6">
            <div v-if="loading" class="flex justify-center items-center h-32">
                <div class="flex items-center gap-3">
                    <span class="loading loading-spinner loading-lg text-primary"></span>
                    <span class="text-base-content/60 font-medium">Loading projects...</span>
                </div>
            </div>
            
            <div v-else-if="projects.length === 0" class="text-center py-12">
                <div class="p-6 bg-gradient-to-br from-base-200/50 to-base-300/30 rounded-3xl border border-primary/10 max-w-md mx-auto">
                    <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-2xl flex items-center justify-center">
                        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-2">No Projects Yet</h3>
                    <p class="text-base-content/60 mb-6">Create your first project to get started organizing your tasks!</p>
                    <button @click="openAddProjectModal" class="btn btn-primary rounded-xl hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create Project
                    </button>
                </div>
            </div>

            <div v-else class="space-y-4">
                <div v-for="project in sortedProjects" :key="project.project_id" 
                     class="group bg-gradient-to-r from-base-200/50 to-base-300/30 rounded-2xl p-6 border border-primary/10 hover:shadow-xl hover:scale-[1.01] transition-all duration-300 cursor-pointer relative overflow-hidden"
                     :class="{'ring-2 ring-primary ring-offset-2 ring-offset-base-100 shadow-xl scale-[1.01]': project.project_id === activeProjectID}"
                     @click="selectProject(project)">
                    
                    <!-- Active Project Indicator -->
                    <div v-if="project.project_id === activeProjectID" 
                         class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-16 bg-gradient-to-b from-primary to-secondary rounded-r-full"></div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-4 mb-3">
                                <!-- Project Avatar -->
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-r from-primary to-secondary flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-300">
                                    <span class="text-white font-bold text-lg">
                                        {{ getProjectInitials(project.project_name) }}
                                    </span>
                                </div>
                                
                                <div class="flex-1">
                                    <h3 class="font-bold text-xl text-primary mb-1">{{ project.project_name }}</h3>
                                    <div class="flex items-center gap-3 text-sm">
                                        <span v-if="project.is_owner" class="px-3 py-1 bg-gradient-to-r from-primary to-primary/80 text-white rounded-full text-xs font-semibold">Owner</span>
                                        <span v-else-if="project.permission_level === 'admin'" class="px-3 py-1 bg-gradient-to-r from-secondary to-secondary/80 text-white rounded-full text-xs font-semibold">Admin</span>
                                        <span v-else class="px-3 py-1 bg-base-300 text-base-content/70 rounded-full text-xs font-semibold">Member</span>
                                        <span class="text-base-content/40">•</span>
                                        <span class="text-base-content/60 font-medium">{{ formatDate(project.created_at) }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <p v-if="project.description" class="text-base-content/70 text-sm line-clamp-2">
                                {{ project.description }}
                            </p>
                        </div>

                        <!-- Project Actions -->
                        <!-- <div class="dropdown dropdown-end">
                            <div tabindex="0" role="button" class="btn btn-ghost btn-sm opacity-0 group-hover:opacity-100 transition-all duration-300 rounded-xl hover:bg-primary/10"
                                 @click.stop>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg>
                            </div>
                            <ul tabindex="0" class="dropdown-content z-[1000] menu p-2 shadow-2xl bg-base-100 rounded-2xl w-48 border border-primary/20">
                                <li v-if="project.is_owner">
                                    <a @click.stop="editProject(project)" class="rounded-xl hover:bg-primary/10 transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit Project
                                    </a>
                                </li>
                                <li v-if="project.is_owner">
                                    <a @click.stop="deleteProject(project)" class="text-error rounded-xl hover:bg-error/10 transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete Project
                                    </a>
                                </li>
                                <li v-if="!project.is_owner">
                                    <a @click.stop="leaveProject(project)" class="text-warning rounded-xl hover:bg-warning/10 transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Leave Project
                                    </a>
                                </li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Project Modal -->
        <dialog ref="addProjectModal" class="modal">
            <div class="modal-box bg-gradient-to-br from-base-100 to-base-200 rounded-3xl border border-primary/20 shadow-2xl max-w-md">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-3 bg-primary/20 rounded-xl">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-2xl text-primary">Create New Project</h3>
                </div>
                
                <form @submit.prevent="createProject" class="space-y-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-base-content/80">Project Name</span>
                        </label>
                        <input v-model="newProject.name" type="text" placeholder="Enter project name" 
                               class="input input-bordered rounded-xl border-primary/20 focus:border-primary focus:ring-2 focus:ring-primary/20 bg-base-200/50" required>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-base-content/80">Description</span>
                        </label>
                        <textarea v-model="newProject.description" class="textarea textarea-bordered rounded-xl border-primary/20 focus:border-primary focus:ring-2 focus:ring-primary/20 bg-base-200/50" 
                                  placeholder="Project description (optional)" rows="3"></textarea>
                    </div>
                    <div class="modal-action gap-3 pt-4">
                        <button type="button" class="btn btn-ghost rounded-xl hover:bg-base-200/50 transition-all duration-200" @click="closeAddProjectModal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-xl hover:shadow-lg hover:scale-[1.02] transition-all duration-300" :disabled="!newProject.name.trim()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create Project
                        </button>
                    </div>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button @click="closeAddProjectModal">close</button>
            </form>
        </dialog>

        <!-- Edit Project Modal -->
        <dialog ref="editProjectModal" class="modal">
            <div class="modal-box bg-gradient-to-br from-base-100 to-base-200 rounded-3xl border border-primary/20 shadow-2xl max-w-md">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-3 bg-primary/20 rounded-xl">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                               class="input input-bordered rounded-xl border-primary/20 focus:border-primary focus:ring-2 focus:ring-primary/20 bg-base-200/50" required>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-base-content/80">Description</span>
                        </label>
                        <textarea v-model="editingProject.description" class="textarea textarea-bordered rounded-xl border-primary/20 focus:border-primary focus:ring-2 focus:ring-primary/20 bg-base-200/50" 
                                  placeholder="Project description (optional)" rows="3"></textarea>
                    </div>
                    <div class="modal-action gap-3 pt-4">
                        <button type="button" class="btn btn-ghost rounded-xl hover:bg-base-200/50 transition-all duration-200" @click="closeEditProjectModal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-xl hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
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
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            userId: '1000000',
            projects: [],
            sortedProjects: [],
            loading: false,
            error: '',
            success: '',
            activeProjectID: null,
            sortBy: 'date_desc',
            newProject: {
                name: '',
                description: ''
            },
            editingProject: {
                project_id: null,
                project_name: '',
                description: ''
            }
        }
    },
    mounted() {
        this.loadProjects();
        this.$bus.$on("refresh-projects", this.loadProjects);
    },
    beforeUnmount() {
        this.$bus.$off("refresh-projects", this.loadProjects);
    },
    methods: {
        async loadProjects() {
            this.loading = true;
            try {
                const userId = this.getUserIDFromLocal();
                const res = await axios.get('http://localhost/IPT_FINAL_PROJ/backend/index.php/fetch-user-projects', {
                    params: { user_id: userId }
                });

                if (res.data.success) {
                    this.projects = res.data.data.map(project => ({
                        ...project,
                        is_owner: project.owner_id === userId
                    }));
                    this.sortProjects(this.sortBy);
                } else {
                    this.handleError('Failed to load projects');
                }
            } catch (error) {
                this.handleError('Something went wrong during fetch');
            } finally {
                this.loading = false;
            }
        },

        sortProjects(sortType) {
            this.sortBy = sortType;
            let sorted = [...this.projects];

            switch (sortType) {
                case 'name_asc':
                    sorted.sort((a, b) => a.project_name.localeCompare(b.project_name));
                    break;
                case 'name_desc':
                    sorted.sort((a, b) => b.project_name.localeCompare(a.project_name));
                    break;
                case 'date_asc':
                    sorted.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                    break;
                case 'date_desc':
                    sorted.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                    break;
            }

            this.sortedProjects = sorted;
        },

        selectProject(project) {
            this.activeProjectID = project.project_id;
            this.$bus.$emit("FetchTasksByProj", project.project_id);
            this.$bus.$emit("ProjectSelected", project);
        },

        getProjectInitials(name) {
            return name.split(' ')
                      .map(word => word.charAt(0))
                      .join('')
                      .toUpperCase()
                      .substring(0, 2);
        },

        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
        },

        getUserIDFromLocal() {
            const user = JSON.parse(localStorage.getItem('user'));
            if (user && user.id) {
                return user.id;
            } else {
                throw new Error("Failed to get user id");
            }
        },

        // Modal methods
        openAddProjectModal() {
            this.newProject = { name: '', description: '' };
            this.$refs.addProjectModal.showModal();
        },

        closeAddProjectModal() {
            this.$refs.addProjectModal.close();
        },

        async createProject() {
            try {
                const userId = this.getUserIDFromLocal();
                const res = await axios.post('http://localhost/IPT_FINAL_PROJ/backend/index.php/create-project', {
                    owner_id: userId,
                    project_name: this.newProject.name,
                    description: this.newProject.description
                });

                if (res.data.success) {
                    this.handleSuccess('Project created successfully!');
                    this.closeAddProjectModal();
                    this.loadProjects();
                } else {
                    this.handleError(res.data.message || 'Failed to create project');
                }
            } catch (error) {
                this.handleError('Error creating project');
            }
        },

        editProject(project) {
            this.editingProject = {
                project_id: project.project_id,
                project_name: project.project_name,
                description: project.description || ''
            };
            this.$refs.editProjectModal.showModal();
        },

        closeEditProjectModal() {
            this.$refs.editProjectModal.close();
        },

        async updateProject() {
            try {
                const res = await axios.put('http://localhost/IPT_FINAL_PROJ/backend/index.php/update-project', {
                    project_id: this.editingProject.project_id,
                    project_name: this.editingProject.project_name,
                    description: this.editingProject.description
                });

                if (res.data.success) {
                    this.handleSuccess('Project updated successfully!');
                    this.closeEditProjectModal();
                    this.loadProjects();
                } else {
                    this.handleError(res.data.message || 'Failed to update project');
                }
            } catch (error) {
                this.handleError('Error updating project');
            }
        },

        async deleteProject(project) {
            if (!confirm(`Are you sure you want to delete "${project.project_name}"? This action cannot be undone.`)) {
                return;
            }

            try {
                const res = await axios.delete('http://localhost/IPT_FINAL_PROJ/backend/index.php/delete-project', {
                    data: { project_id: project.project_id }
                });

                if (res.data.success) {
                    this.handleSuccess('Project deleted successfully!');
                    if (this.activeProjectID === project.project_id) {
                        this.activeProjectID = null;
                        this.$bus.$emit("ProjectDeleted");
                    }
                    this.loadProjects();
                } else {
                    this.handleError(res.data.message || 'Failed to delete project');
                }
            } catch (error) {
                this.handleError('Error deleting project');
            }
        },

        async leaveProject(project) {
            if (!confirm(`Are you sure you want to leave "${project.project_name}"?`)) {
                return;
            }

            try {
                const userId = this.getUserIDFromLocal();
                const res = await axios.delete('http://localhost/IPT_FINAL_PROJ/backend/index.php/leave-project', {
                    data: { 
                        project_id: project.project_id, 
                        user_id: userId 
                    }
                });

                if (res.data.success) {
                    this.handleSuccess('Left project successfully!');
                    if (this.activeProjectID === project.project_id) {
                        this.activeProjectID = null;
                        this.$bus.$emit("ProjectLeft");
                    }
                    this.loadProjects();
                } else {
                    this.handleError(res.data.message || 'Failed to leave project');
                }
            } catch (error) {
                this.handleError('Error leaving project');
            }
        },

        handleSuccess(message) {
            this.success = message;
            this.error = '';
            alert(this.success);
        },

        handleError(message) {
            this.error = message;
            this.success = '';
            alert(this.error);
        }
    },

    watch: {
        activeProjectID(newVal) {
            if (newVal !== null) {
                const selectedProject = this.projects.find(p => p.project_id === newVal);
                if (selectedProject) {
                    this.$bus.$emit("FetchTasksByProj", selectedProject.project_id);
                }
            }
        }
    }
}
</script>

<style scoped>
/* Line clamp utility for description text */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Custom scrollbar styling using Tailwind-compatible properties */
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

/* Enhanced focus states for accessibility */
.btn:focus,
.input:focus,
.textarea:focus {
    outline: 2px solid rgba(139, 92, 246, 0.6);
    outline-offset: 2px;
}

/* Smooth transitions for all interactive elements */
* {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}

/* Enhanced button hover effects */
.btn:hover {
    transform: translateY(-1px);
}

/* Project card stagger animation */
.space-y-4 > div:nth-child(1) { animation-delay: 0ms; }
.space-y-4 > div:nth-child(2) { animation-delay: 100ms; }
.space-y-4 > div:nth-child(3) { animation-delay: 200ms; }
.space-y-4 > div:nth-child(4) { animation-delay: 300ms; }
.space-y-4 > div:nth-child(5) { animation-delay: 400ms; }

/* Modal entrance animation */
.modal-box {
    animation: slideInUp 0.3s ease-out;
}

@keyframes slideInUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
}

}

/* Project card hover animation */
.group:hover .group-hover:scale-105 {
transform: scale(1.05);
}

/* Active project indicator animation */
@keyframes pulse {
0%, 100% {
opacity: 1;
}
50% {
opacity: 0.7;
}

}

.ring-primary {
animation: pulse 2s infinite;
}

/* Dropdown menu animation */
.dropdown-content {
animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
from {
opacity: 0;
transform: translateY(-10px);
}
to {
opacity: 1;
transform: translateY(0);
}

}

/* Button loading state */
.btn[disabled] {
opacity: 0.7;
cursor: not-allowed;
}

/* Responsive adjustments */
@media (max-width: 768px) {
.flex.items-center.justify-between {
flex-direction: column;
align-items: flex-start;
gap: 1rem;
}

}

/* Button loading state */
.btn[disabled] {
opacity: 0.7;
cursor: not-allowed;
}

/* Responsive adjustments */
@media (max-width: 768px) {
.flex.items-center.justify-between {
flex-direction: column;
align-items: flex-start;
gap: 1rem;
}

.flex.gap-3 {
    width: 100%;
    justify-content: space-between;
}

.dropdown-end {
    position: static;
}

.modal-box {
    width: 95%;
    margin: 0 auto;
}

}

/* Dark mode adjustments */
.dark .bg-base-200 {
background-color: #1e293b;
}

.dark .bg-base-300 {
background-color: #1a2536;
}

.dark .text-base-content {
color: #e2e8f0;
}

.dark .text-base-content {
color: rgba(226, 232, 240, 0.6);
}

.dark .border-primary {
border-color: rgba(139, 92, 246, 0.2);
}

.dark .bg-primary {
background-color: rgba(139, 92, 246, 0.1);
}

/* Custom transitions for specific elements */
.project-card {
transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.project-card:hover {
transform: translateY(-2px);
box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
}

/* Loading spinner animation */
.loading-spinner {
animation: spin 1s linear infinite;
}

@keyframes spin {
from {
transform: rotate(0deg);
}
to {
transform: rotate(360deg);
}
}
/* Error message animation */
.error-message {
animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
}

@keyframes shake {
10%, 90% {
transform: translateX(-1px);
}
20%, 80% {
transform: translateX(2px);
}
30%, 50%, 70% {
transform: translateX(-4px);
}
40%, 60% {
transform: translateX(4px);
}
}

/* Success message animation */
.success-message {
animation: bounceIn 0.5s;
}

@keyframes bounceIn {
0% {
opacity: 0;
transform: scale(0.3);
}
50% {
opacity: 1;
transform: scale(1.05);
}
70% {
transform: scale(0.9);
}
100% {
transform: scale(1);
}
}
</style>