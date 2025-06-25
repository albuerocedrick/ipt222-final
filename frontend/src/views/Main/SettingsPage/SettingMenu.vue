<template>
    <div class="w-2/5 bg-base-100 rounded-3xl shadow-2xl border border-primary/10 h-full">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-primary/10 to-secondary/10 border-b border-primary/20 p-6 rounded-t-3xl">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-primary/20 rounded-xl">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-black text-3xl text-primary tracking-wide">Settings</h2>
                    <p class="text-base-content/60 text-sm">Customize your experience</p>
                </div>
            </div>
        </div>

        <!-- Menu Items -->
        <nav class="p-6">
            <ul class="space-y-3">
                <li v-for="(item, index) in menuItems" :key="index">
                    <button
                        @click="selectMenu(item.id)"
                        class="group w-full flex items-center gap-4 p-4 rounded-xl transition-all duration-300 hover:bg-primary/10 hover:shadow-md hover:scale-[1.02] relative overflow-hidden text-left"
                        :class="[{
                            'bg-gradient-to-r from-primary to-primary/80 text-primary-content shadow-lg scale-[1.02] border-l-4 border-accent': item.id === selectedMenuItem
                        }]">
                        
                        <!-- Icon Container -->
                        <div class="flex-shrink-0 p-3 rounded-lg transition-all duration-300"
                             :class="[{
                                 'bg-white/20': item.id === selectedMenuItem,
                                 'bg-primary/10 group-hover:bg-primary/20': item.id !== selectedMenuItem
                             }]">
                            <span class="block w-6 h-6" v-html="item.icon"></span>
                        </div>
                        
                        <!-- Text Content -->
                        <div class="flex-1">
                            <span class="font-semibold text-lg tracking-wide block">{{ item.name }}</span>
                            <span class="text-sm opacity-80">{{ item.description }}</span>
                        </div>
                        
                        <!-- Active Indicator -->
                        <div v-if="item.id === selectedMenuItem" 
                             class="absolute right-0 top-1/2 transform -translate-y-1/2 w-1 h-12 bg-accent rounded-l-full"></div>
                        
                        <!-- Arrow Icon -->
                        <div class="flex-shrink-0 transition-all duration-300"
                             :class="[{
                                 'text-white/80': item.id === selectedMenuItem,
                                 'text-base-content/40 group-hover:text-primary': item.id !== selectedMenuItem
                             }]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </button>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    name: "SettingMenu",
    data() {
        return {
            selectedMenuItem: 'profile',
            menuItems: [
                {
                    id: 'profile',
                    name: 'Profile',
                    description: 'Manage your personal information',
                    icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                           </svg>`
                },
                {
                    id: 'password',
                    name: 'Change Password',
                    description: 'Update your account security',
                    icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                           </svg>`
                },
                // {
                //     id: 'theme',
                //     name: 'Theme',
                //     description: 'Customize your app appearance',
                //     icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                //             <path stroke-linecap="round" stroke-linejoin="round" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM7 3H5a2 2 0 00-2 2v12a4 4 0 004 4h2a2 2 0 002-2V5a2 2 0 00-2-2z" />
                //            </svg>`
                // }
            ]
        };
    },
    methods: {
        selectMenu(menuId) {
            this.selectedMenuItem = menuId;
            this.$emit('menu-selected', menuId);
        }
    },
    mounted() {
        // Emit initial selection
        this.$emit('menu-selected', this.selectedMenuItem);
    }
};
</script>

<style scoped>
/* Smooth transitions for all interactive elements */
* {
    transition: all 0.2s ease-in-out;
}

/* Enhanced button hover effects */
button:hover {
    transform: translateY(-1px);
}

/* Custom scrollbar if content overflows */
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

/* Enhanced accessibility */
button:focus {
    outline: 2px solid rgba(139, 92, 246, 0.6);
    outline-offset: 2px;
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

/* Mobile responsiveness */
@media (max-width: 768px) {
    .w-2\/5 {
        width: 100%;
        margin-bottom: 1rem;
    }
    
    .text-3xl {
        font-size: 1.5rem;
    }
    
    .p-6 {
        padding: 1rem;
    }
    
    .gap-4 {
        gap: 0.75rem;
    }
}
</style>