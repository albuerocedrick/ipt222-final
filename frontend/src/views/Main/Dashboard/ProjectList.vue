<template>
    <div class="row-span-2 box bg-base-100 transition-all duration-300 hover:scale-[1.01] border border-base-300/50">
        <!-- Header -->
        <div class="flex flex-row justify-between items-center border-b border-base-300/50 rounded-t-4xl h-16 bg-gradient-to-r from-primary/10 to-secondary/10 px-4"> 
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-lg bg-primary/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                </div>
                <p class="font-bold text-xl bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">Projects</p>
            </div>
            <div class="badge badge-primary badge-outline font-semibold">
                {{ projects.length }} project{{ projects.length !== 1 ? 's' : '' }}
            </div>
        </div>
        
        <!-- Content -->
        <div class="p-4 space-y-3 max-h-[calc(100%-4rem)] overflow-y-auto">
            <div v-if="loading" class="flex flex-col items-center justify-center h-32 text-center">
                <span class="loading loading-spinner loading-lg text-primary"></span>
                <p class="mt-4 text-base-content/60">Loading projects...</p>
            </div>
            
            <div v-else-if="projects.length === 0" class="flex flex-col items-center justify-center h-32 text-center">
                <div class="p-4 rounded-full bg-primary/10 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <p class="text-base-content/60 font-medium">No projects found</p>
                <p class="text-sm text-base-content/40">You're not assigned to any projects yet</p>
            </div>
            
            <div v-for="project in projects" :key="project.project_id" 
                 class="group p-4 rounded-xl bg-gradient-to-r from-base-200/50 to-base-300/30 border border-base-300/30 hover:border-primary/30 hover:shadow-md transition-all duration-300 hover:scale-[1.02] cursor-pointer"
                 @click="viewProject(project.project_id)">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 flex-1">
                        <!-- Project Icon -->
                        <div class="p-2 rounded-lg transition-all duration-300"
                             :class="getProjectColor(project.status).bg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" :class="getProjectColor(project.status).text" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                        </div>
                        
                        <!-- Project Info -->
                        <div class="flex-1">
                            <h4 class="font-semibold text-base-content group-hover:text-primary transition-colors">{{ project.project_name }}</h4>
                            <p class="text-sm text-base-content/60 line-clamp-1">{{ project.description || 'No description' }}</p>
                        </div>
                    </div>
                    
                    <!-- Status & Progress -->
                    <div class="flex flex-col items-end gap-2">
                        <!-- <div class="badge badge-sm" :class="getProjectColor(project.status).badge">
                            {{ project.status || 'Active' }}
                        </div> -->
                        <div class="flex items-center gap-2">
                            <div class="w-16 h-2 bg-base-300 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-500" 
                                     :class="getProjectColor(project.status).progress"
                                     :style="`width: ${calculateProjectProgress(project.project_id)}%`"></div>
                            </div>
                            <span class="text-xs text-base-content/60 font-medium">{{ calculateProjectProgress(project.project_id) }}%</span>
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
            projects: [],
            projectTasks: {},
            loading: true,
            error: null
        }
    },
    mounted() {
        this.fetchUserProjects();
    },
    methods: {
        async fetchUserProjects() {
            try {
                this.loading = true;
                this.error = null;
                
                const user = JSON.parse(localStorage.getItem('user'));
                if (!user?.id) {
                    throw new Error('User not authenticated');
                }

                const response = await axios.get('https://act-track.x10.mx/index.php/fetch-user-projects', {
                    params: { user_id: user.id }
                });

                if (!response.data?.success) {
                    throw new Error(response.data?.message || 'Failed to fetch projects');
                }

                // Ensure projects is always an array with required fields
                this.projects = (Array.isArray(response.data.data) 
                    ? response.data.data 
                    : []).map(project => ({
                        ...project,
                        task_count: project.task_count || 0,
                        status: project.status || 'Planning'
                    }));

                // Fetch tasks for all projects
                await this.fetchTasksForProjects();
                    
            } catch (err) {
                console.error('Error fetching projects:', err);
                this.error = err.message || 'Failed to load projects';
                this.projects = [];
            } finally {
                this.loading = false;
            }
        },
        async fetchTasksForProjects() {
            try {
                // Only proceed if we have projects
                if (!Array.isArray(this.projects) || this.projects.length === 0) {
                    return;
                }

                const projectIds = this.projects.map(p => p.project_id).join(',');
                if (!projectIds) return;

                const response = await axios.get('https://act-track.x10.mx/index.php/fetch-tasks-for-projects', {
                    params: { project_ids: projectIds }
                });

                if (response.data?.success) {
                    // Organize tasks by project_id
                    this.projectTasks = response.data.tasks.reduce((acc, task) => {
                        if (!acc[task.project_id]) {
                            acc[task.project_id] = [];
                        }
                        acc[task.project_id].push(task);
                        return acc;
                    }, {});
                }
            } catch (err) {
                console.error('Error fetching project tasks:', err);
                // Don't set error state here as it's secondary data
            }
        },
        calculateProjectProgress(projectId) {
            const tasks = this.projectTasks[projectId] || [];
            if (tasks.length === 0) return 0;
            
            const completedTasks = tasks.filter(task => 
                task.status === 'Done' || task.user_status === 'Done'
            ).length;
            
            return Math.round((completedTasks / tasks.length) * 100);
        },
        getProjectColor(status) {
            const colors = {
                'Active': {
                    bg: 'bg-success/10',
                    text: 'text-success',
                    badge: 'badge-success badge-outline',
                    progress: 'bg-success'
                },
                'Planning': {
                    bg: 'bg-warning/10',
                    text: 'text-warning',
                    badge: 'badge-warning badge-outline',
                    progress: 'bg-warning'
                },
                'Completed': {
                    bg: 'bg-primary/10',
                    text: 'text-primary',
                    badge: 'badge-primary badge-outline',
                    progress: 'bg-primary'
                },
                'On Hold': {
                    bg: 'bg-base-300',
                    text: 'text-base-content',
                    badge: 'badge-ghost',
                    progress: 'bg-base-content'
                }
            };
            return colors[status] || colors['Active'];
        },
        viewProject(projectId) {
            this.$emit('view-project', projectId);
        }
    }
}
</script>