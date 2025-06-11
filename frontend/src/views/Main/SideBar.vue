<template>
    <div class="box w-[350px] flex flex-col justify-between bg-base-100 shadow-xl">
        <!-- Header Section -->
        <div class="w-full">
            <div class="h-20 flex items-center justify-center border-b border-base-300 bg-gradient-to-r from-primary/10 to-secondary/10 rounded-t-4xl">
                <h1 class="font-black text-3xl bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent tracking-wide">
                    ActTrack
                </h1>
            </div>
            
            <!-- Navigation Menu -->
            <nav class="py-4">
                <ul class="space-y-1 px-3">
                    <li v-for="(item, index) in menuItems" :key="index">
                        <router-link
                            :to="item.path"
                            class="group flex items-center gap-4 p-4 rounded-xl transition-all duration-300 hover:bg-primary/10 hover:shadow-md hover:scale-[1.02] relative overflow-hidden"
                            :class="[{
                                'bg-gradient-to-r from-primary to-primary/80 text-primary-content shadow-lg scale-[1.02] border-l-4 border-accent': item.path === $route.path 
                            }]">
                            
                            <!-- Icon Container -->
                            <div class="flex-shrink-0 p-2 rounded-lg transition-all duration-300"
                                 :class="[{
                                     'bg-white/20': item.path === $route.path,
                                     'bg-primary/10 group-hover:bg-primary/20': item.path !== $route.path
                                 }]">
                                <span class="block w-6 h-6" v-html="item.icon"></span>
                            </div>
                            
                            <!-- Text -->
                            <span class="font-semibold text-lg tracking-wide">{{ item.name }}</span>
                            
                            <!-- Active Indicator -->
                            <div v-if="item.path === $route.path" 
                                 class="absolute right-0 top-1/2 transform -translate-y-1/2 w-1 h-8 bg-accent rounded-l-full"></div>
                        </router-link>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Bottom Section -->
        <div class="border-t border-base-300 bg-base-50 rounded-b-4xl">
            <ul class="p-3 space-y-1">
                <!-- Settings Link -->
                <li>
                    <router-link 
                        to="/main/settings" 
                        class="group flex items-center gap-4 p-4 rounded-xl transition-all duration-300 hover:bg-info/10 hover:shadow-md hover:scale-[1.02]"
                        :class="[{
                            'bg-gradient-to-r from-info to-info/80 text-info-content shadow-lg scale-[1.02]': $route.path === '/main/settings'
                        }]">
                        
                        <div class="flex-shrink-0 p-2 rounded-lg transition-all duration-300"
                             :class="[{
                                 'bg-white/20': $route.path === '/main/settings',
                                 'bg-info/10 group-hover:bg-info/20': $route.path !== '/main/settings'
                             }]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 -960 960 960" fill="currentColor">
                                <path d="m370-80-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-103 78q1 7 1 13.5v27q0 6.5-2 13.5l103 78-110 190-119-50q-11 8-23 15t-24 12L590-80H370Zm70-80h79l14-106q31-8 57.5-23.5T639-327l99 41 39-68-86-65q5-14 7-29.5t2-31.5q0-16-2-31.5t-7-29.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q22 23 48.5 38.5T427-266l13 106Zm42-180q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Zm-2-140Z"/>
                            </svg>
                        </div>
                        <span class="font-semibold text-lg">Settings</span>
                    </router-link>
                </li>

                <!-- Logout Button -->
                <li>
                    <button 
                        @click="LogOut"
                        class="group w-full flex items-center gap-4 p-4 rounded-xl transition-all duration-300 hover:bg-error/10 hover:shadow-md hover:scale-[1.02] text-error hover:text-error">
                        
                        <div class="flex-shrink-0 p-2 rounded-lg bg-error/10 group-hover:bg-error/20 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 -960 960 960" fill="currentColor">
                                <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/>
                            </svg>
                        </div>
                        <span class="font-semibold text-lg">Log Out</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            LogOut() {
                localStorage.removeItem('user');
                this.$router.push('/');
            },
            ClickMenu(index) {
                this.selectedMenu = index;
            }
        },
        data() {
            return {
                selectedMenu: 0,
                menuItems: [
                    {
                        name: 'Dashboard',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                               </svg>`,
                        path: '/main'
                    },
                    {
                        name: 'Tasks',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                               </svg>`,
                        path: '/main/tasks'
                    },
                    {
                        name: 'Projects',
                        icon: `<svg xmlns="http://www.w3.svg/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                               </svg>`,
                        path: '/main/projects'
                    }
                ]
            }
        }
    }
</script>