<template>
    <div class="row-span-2 box bg-base-100  transition-all duration-300 hover:scale-[1.01] border border-base-300/50">
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
            <button class="btn btn-sm btn-primary btn-outline hover:scale-105 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add
            </button>
        </div>
        
        <!-- Content -->
        <div class="p-4 space-y-3 max-h-[calc(100%-4rem)] overflow-y-auto">
            <div v-if="projects.length === 0" class="flex flex-col items-center justify-center h-32 text-center">
                <div class="p-4 rounded-full bg-primary/10 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <p class="text-base-content/60 font-medium">No projects yet</p>
                <p class="text-sm text-base-content/40">Create your first project to get started</p>
            </div>
            
            <div v-for="project in projects" :key="project.id" 
                 class="group p-4 rounded-xl bg-gradient-to-r from-base-200/50 to-base-300/30 border border-base-300/30 hover:border-primary/30 hover:shadow-md transition-all duration-300 hover:scale-[1.02] cursor-pointer">
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
                            <h4 class="font-semibold text-base-content group-hover:text-primary transition-colors">{{ project.name }}</h4>
                            <p class="text-sm text-base-content/60">{{ project.description }}</p>
                        </div>
                    </div>
                    
                    <!-- Status & Progress -->
                    <div class="flex flex-col items-end gap-2">
                        <div class="badge badge-sm" :class="getProjectColor(project.status).badge">
                            {{ project.status }}
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-16 h-2 bg-base-300 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-500" 
                                     :class="getProjectColor(project.status).progress"
                                     :style="`width: ${project.progress}%`"></div>
                            </div>
                            <span class="text-xs text-base-content/60 font-medium">{{ project.progress }}%</span>
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
            projects: [
                {
                    id: 1,
                    name: "QUAMETH",
                    description: "Quality Assessment Method Tool",
                    status: "Active",
                    progress: 75
                },
                {
                    id: 2,
                    name: "ActTrack",
                    description: "Activity Tracking System",
                    status: "Active",
                    progress: 60
                },
                {
                    id: 3,
                    name: "Mobile App",
                    description: "Cross-platform mobile application",
                    status: "Planning",
                    progress: 15
                }
            ]
        }
    },
    methods: {
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
            return colors[status] || colors['Planning'];
        }
    }
}
</script>