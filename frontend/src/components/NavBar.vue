<template>
    <div class="h-20 bg-base-100 box flex flex-row items-center justify-between shadow-lg backdrop-blur-sm">
        <!-- Brand/Page Title Section -->
        <div class="flex items-center">
            <h1 v-if="$route.path === '/'" 
                class="font-black text-2xl lg:text-3xl m-8 bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent tracking-wide">
                ActTrack
            </h1>
            <div v-else class="flex items-center gap-4 m-8">
                <!-- Breadcrumb Icon -->
                <div class="p-2 rounded-xl bg-primary/10">
                    <component :is="currentPageIcon" class="w-6 h-6 text-primary"></component>
                </div>
                <h1 class="font-bold text-2xl lg:text-3xl text-base-content">
                    {{ currentPageTitle }}
                </h1>
            </div>
        </div>

        <!-- Search Section -->
        <div v-if="showSearch" class="flex-1 max-w-md mx-8">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-base-content/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    :placeholder="searchPlaceholder" 
                    class="input rounded-2xl pl-12 pr-4 h-12 font-medium bg-base-200/70 backdrop-blur-sm w-full border-0 focus:outline-0 focus:ring-2 focus:ring-primary/30 focus:bg-base-200 transition-all duration-300" 
                />
            </div>
        </div>

        <!-- Auth Section (Landing Page) -->
        <div v-if="$route.path === '/'" class="flex items-center gap-4 mr-8">
            <router-link
                v-for="(page, index) in pages"
                :key="index"
                :to="page.url"
                :class="[
                    'font-semibold text-sm transition-all duration-300 hover:scale-105',
                    page.label === 'Sign Up' 
                        ? 'px-6 py-3 rounded-xl bg-gradient-to-r from-primary to-primary/80 shadow-lg text-primary-content hover:shadow-xl hover:from-primary/90 hover:to-primary' 
                        : 'px-4 py-2 text-base-content hover:text-primary'
                ]">
                {{ page.label }}
            </router-link>
        </div>

        <!-- User Section (Main App) -->
        <div v-else class="flex items-center gap-3 mr-8">
            <!-- Add Task Button -->
            <button 
                class="btn btn-primary rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 font-semibold" 
                onclick="my_modal_3.showModal()">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Task
            </button>

            <!-- Enhanced Modal -->
            <dialog id="my_modal_3" class="modal backdrop-blur-sm">
                <div class="modal-box box max-w-lg bg-base-100 shadow-2xl">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between pb-4 border-b border-base-300">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-xl bg-primary/10">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <h1 class="font-bold text-xl text-base-content">Create New Task</h1>
                        </div>
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost hover:bg-error/10 hover:text-error transition-colors">✕</button>
                        </form>
                    </div>

                    <!-- Modal Form -->
                    <form class="flex flex-col gap-6 pt-6">
                        <!-- Task Name -->
                        <div class="form-control">
                            <div class="flex items-center gap-3 p-4 rounded-xl bg-base-200/50 border-2 border-transparent focus-within:border-primary/30 focus-within:bg-base-200 transition-all duration-300">
                                <div class="text-primary/70">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 -960 960 960">
                                        <path d="m438-240 226-226-58-58-169 169-84-84-57 57 142 142ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/>
                                    </svg>
                                </div>
                                <input 
                                    type="text" 
                                    placeholder="Task name" 
                                    class="flex-1 bg-transparent border-0 focus:outline-0 font-medium text-base placeholder:text-base-content/50" 
                                />
                            </div>
                        </div>

                        <!-- Date Range -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label font-semibold text-sm text-base-content/80">Start Date</label>
                                <input 
                                    type="date" 
                                    class="input rounded-xl border-2 border-base-300 focus:border-primary focus:outline-0 h-12 font-medium bg-base-200/50 transition-all duration-300" 
                                />
                            </div>
                            <div class="form-control">
                                <label class="label font-semibold text-sm text-base-content/80">End Date</label>
                                <input 
                                    type="date" 
                                    class="input rounded-xl border-2 border-base-300 focus:border-primary focus:outline-0 h-12 font-medium bg-base-200/50 transition-all duration-300" 
                                />
                            </div>
                        </div>

                        <!-- Project Selection -->
                        <div class="form-control flex flex-col w-full">
                            <label class="label font-semibold text-sm text-base-content/80">Project</label>
                            <select class="select w-full rounded-xl border-2 border-base-300 focus:border-primary focus:outline-0 bg-base-200/50 font-medium transition-all duration-300">
                                <option disabled selected>Choose a project</option>
                                <option value="ipt222">IPT222 - ActTrack</option>
                                <option value="personal">Personal Tasks</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="form-control flex flex-col">
                            <label class="label font-semibold text-sm text-base-content/80">Description</label>
                            <textarea 
                                rows="4" 
                                placeholder="Task description..."
                                class="textarea rounded-xl w-full border-2 border-base-300 focus:border-primary focus:outline-0 bg-base-200/50 font-medium resize-none transition-all duration-300"
                            ></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button 
                            type="submit" 
                            class="btn btn-primary rounded-xl w-full font-semibold shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Create Task
                        </button>
                    </form>
                </div>
            </dialog>

            <!-- Notifications -->
            <div class="tooltip tooltip-bottom" data-tip="Notifications">
                <button class="btn btn-ghost btn-circle hover:bg-primary/10 hover:text-primary transition-all duration-300 relative">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 -960 960 960">
                        <path d="M160-200v-80h80v-280q0-83 50-147.5T420-792v-28q0-25 17.5-42.5T480-880q25 0 42.5 17.5T540-820v28q80 20 130 84.5T720-560v280h80v80H160Zm320-300Zm0 420q-33 0-56.5-23.5T400-160h160q0 33-23.5 56.5T480-80ZM320-280h320v-280q0-66-47-113t-113-47q-66 0-113 47t-47 113v280Z"/>
                    </svg>
                    <!-- Notification Badge -->
                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-error rounded-full"></div>
                </button>
            </div>

            <!-- User Dropdown -->
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="flex items-center gap-3 p-2 rounded-xl hover:bg-base-200 transition-all duration-300 cursor-pointer">
                    <avatar class="rounded-full ring-2 ring-primary/20 hover:ring-primary/40 transition-all duration-300"/>
                    <svg class="w-4 h-4 text-base-content/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                <div tabindex="0" class="dropdown-content bg-base-100 w-64 box mt-2 shadow-xl border border-base-300">
                    <!-- User Info Header -->
                    <div class="p-4 border-b border-base-300 bg-gradient-to-r from-primary/5 to-secondary/5">
                        <div class="flex items-center gap-3">
                            <avatar class="rounded-full ring-2 ring-primary/30"/>
                            <div>
                                <p class="font-semibold text-base-content">{{ userInfo.name }}</p>
                                <p class="text-sm text-base-content/60">ID: {{ userInfo.userID }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dropdown Menu Items -->
                    <div class="p-2">
                        <router-link 
                            to="/main/settings" 
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-base-200 transition-colors text-sm font-medium">
                            <svg class="w-5 h-5 text-base-content/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Account Settings
                        </router-link>
                        <hr class="my-2 border-base-300">
                        <button 
                            @click="logout"
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-error/10 hover:text-error transition-colors text-sm font-medium w-full text-left">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Sign Out
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Avatar from './Avatar.vue';

export default {
    components: {
        Avatar,
    },
    data() {
        return {
            pages: [
                {
                    label: 'Log In',
                    url: '/login'
                },
                {
                    label: 'Sign Up',
                    url: '/signup'
                }
            ],
            info: {
                userID: '',
                name: '',
            }
        }
    },
    computed: {
        userInfo() {
            const user = localStorage.getItem('user');
            if (!user) {
                return {
                    email: 'N/A',
                    name: 'N/A'
                };
            }

            try {
                const parsed = JSON.parse(user);
                return {
                    userID: parsed.id || 'N/A',
                    name: parsed.f_name + ' ' + parsed.l_name || 'N/A'
                };
            } catch (error) {
                console.error("Error parsing localStorage user:", error);
                return {
                    userID: 'N/A',
                    name: 'N/A'
                };
            }
        },
        currentPageTitle() {
            const pathTitles = {
                '/main': 'Dashboard',
                '/main/tasks': 'Tasks',
                '/main/projects': 'Projects',
                '/main/settings': 'Settings'
            };
            return pathTitles[this.$route.path] || 'ActTrack';
        },
        currentPageIcon() {
            const pathIcons = {
                '/main': 'DashboardIcon',
                '/main/tasks': 'TasksIcon',
                '/main/projects': 'ProjectsIcon',
                '/main/settings': 'SettingsIcon'
            };
            return pathIcons[this.$route.path] || 'DashboardIcon';
        },
        showSearch() {
            return ['/main/tasks', '/main/projects'].includes(this.$route.path);
        },
        searchPlaceholder() {
            if (this.$route.path === '/main/tasks') return 'Search tasks...';
            if (this.$route.path === '/main/projects') return 'Search projects...';
            return 'Search...';
        }
    },
    methods: {
        logout() {
            localStorage.removeItem('user');
            this.$router.push('/');
        }
    },
    // Icon components as template literals
    DashboardIcon: {
        template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>`
    },
    TasksIcon: {
        template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>`
    },
    ProjectsIcon: {
        template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>`
    },
    SettingsIcon: {
        template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>`
    }
}
</script>