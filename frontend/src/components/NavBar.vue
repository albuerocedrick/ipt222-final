<template>
<div :class=" [ 'h-20', 'box', 'flex', 'flex-row', 'items-center', 'justify-between', 'bg-[#ebe8e2]']">
        <h1 :class="['font-bold', 'lg:text-2xl md:text-xl text-sm', 'm-8', 'text-black']">  ActTrack</h1>
        <ul v-if="$route.path === '/'" class="flex flex-row justify-evenly lg:w-1/7 w-3/8">
            <li
              v-for="(page, index) in pages"
              :key="index">
                <router-link
                  :to="page.url"
                  :class="['font-medium text-sm ', {' px-4 py-4 rounded-md bg-[#50b9a1] text-black': page.label === 'Sign Up'}]"> {{ page.label }} </router-link>
            </li>
        </ul>
        <div v-else class="dropdown dropdown-end">
            <avatar tabindex="0" role="button" />
            <div tabindex="0" class="dropdown-content bg-[#ebe8e2] w-40 box mt-2 p-4 font-medium">
                <p>User ID: {{ userInfo.userID }}</p>
                <p>Username: {{ userInfo.username }}</p>
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
                username: '',
            }
        }
    },
    computed: {
        userInfo() {
            const user = localStorage.getItem('user');
            if (!user) {
                return {
                    userID: 'N/A',
                    username: 'N/A'
                };
            }

            try {
                const parsed = JSON.parse(user);
                return {
                    userID: parsed.id || 'N/A',
                    username: parsed.username || 'N/A'
                };
            } catch (error) {
                console.error("Error parsing localStorage user:", error);
                return {
                    userID: 'N/A',
                    username: 'N/A'
                };
            }
        }
    }
}
</script>