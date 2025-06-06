<template>
    <div class="box w-[300px] flex flex-col justify-between bg-[#ebe8e2] mb-4">
        <div class="w-full">
            <ul class="w-19/20 px-4 pt-4">
                <li v-for="(item, index) in menuItems" :key="index" class="mb-2">
                <router-link
                  :to="item.path"
                  class="flex items-center p-4 rounded-lg hover:bg-[#97ddcd]/30 transition-colors"
                  :class="[{' bg-[#97ddcd]':  item.path === $route.path }, {' shadow-md':  item.path === $route.path }]">
                    <span :class="['mr-3' ] " v-html="item.icon"></span>
                    <span class=" font-medium text-xl" >{{item.name }}</span>
                </router-link>
                </li>
            </ul>
        </div>
        <div>
            <ul class="w-19/20 px-4 pt-4">
                <li class="mb-2">
                    <a href="#" class="flex items-center p-4 rounded-lg hover:bg-[#a2cffe]/30 transition-colors" @click="LogOut">
                        <span :class="['mr-3']">
                            <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px" fill="#000000"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
                            </span>
                        <span class=" font-medium text-xl">Log Out</span>
                    </a>
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
                    icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>`,
                    path: '/main'
                    },
                    {
                    name: 'Tasks',
                    icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>`,
                    path:    '/main/tasks'
                    },
                    {
                    name: 'Projects',
                    icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>`,
                    path:    '/main/projects'
                    },
                    // {
                    // name: 'Calendar',
                    // icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    //         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    //         </svg>`,
                    // path:    '/main/calendar'
                    // },
                    // {
                    // name: 'Settings',
                    // icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    //         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    //         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    //         </svg>`,
                    // path:    '/main/tasks'
                    // }
                ]
            }
        }
    }
</script>