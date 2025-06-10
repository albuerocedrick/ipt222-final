<template>
<div :class=" [ 'h-20 bg-base-100', 'box', 'flex', 'flex-row', 'items-center', 'justify-between']">
        <h1 v-if="$route.path === '/'" :class="['font-bold', 'lg:text-2xl md:text-xl text-sm', 'm-8', 'text-base-content']">  ActTrack</h1>
        <h1 v-else-if="$route.path === '/main'" :class="['font-bold', 'lg:text-2xl md:text-xl text-sm', 'm-8', 'text-base-content']">Dashboard</h1>
        <h1 v-else-if="$route.path === '/main/tasks'" :class="['font-bold', 'lg:text-2xl md:text-xl text-sm', 'm-8', 'text-base-content']">  Tasks</h1>
        <h1 v-else-if="$route.path === '/main/projects'" :class="['font-bold', 'lg:text-2xl md:text-xl text-sm', 'm-8', 'text-base-content']">  Tasks</h1>
        <div v-if="$route.path === '/main/tasks'" class="w-90">
            <input type="password" placeholder="Search Tasks" class="input rounded-2xl focus:outline-0 h-12 font-medium bg-base-200 w-full" />
        </div>
        <div v-else-if="$route.path === '/main/projects'" class="w-90">
            <input type="password" placeholder="Search Projects" class="input rounded-2xl focus:outline-0 h-12 font-medium bg-base-200 w-full" />
        </div>
        <ul v-if="$route.path === '/'" class="flex flex-row justify-evenly lg:w-1/7 w-3/8">
            <li
              v-for="(page, index) in pages"
              :key="index">
                <router-link
                  :to="page.url"
                  :class="['font-medium text-sm', {' px-4 py-4 rounded-md bg-primary shadow-md text-primary-content hover-effect': page.label === 'Sign Up'}]"> {{ page.label }} </router-link>
            </li>
        </ul>
        <div v-else class="flex flex-row gap-2 items-center">
            <button class="btn btn-primary rounded-2xl hover-effect" onclick="my_modal_3.showModal()">Add Task</button>
            <dialog id="my_modal_3" class="modal">
            <div class="modal-box box">
                <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <form class="flex flex-col items-center">
                    <div class="flex flex-row gap-2 items-center mt-4 border-b border-neutral/30 h-20 w-full">
                        <span class="text-neutral/60">
                            <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" fill="currentColor"><path d="m438-240 226-226-58-58-169 169-84-84-57 57 142 142ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/></svg>
                        </span>
                        <input type="password" placeholder="Name of Task" class="input rounded-2xl border-0 focus:outline-0 h-10 font-medium bg-base-200 flex-1" />
                    </div>
                    <div class="flex flex-row pt-6 w-full gap-6">
                        <div class="w-1/2">
                            <p class="font-medium">Start Date</p>
                            <input type="date" class="input rounded-2xl border-0 focus:!outline-0 h-10 font-medium bg-base-200" />
                        </div>
                        <div class="w-1/2">
                            <p class="font-medium">End Date</p>
                            <input type="date" class="input rounded-2xl border-0 focus:!outline-0 h-10 font-medium bg-base-200" />
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 mt-6 w-full">
                        <p class="font-medium">Project</p>
                        <select class="block w-full box bg-base-200 p-2 border-2 border-none rounded-4xl text-gray-700 appearance-none focus:outline-none cursor-pointer px-4 font-medium ">
                            <option class="font-medium" value="By Deadline">IPT222 - ActTrack</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-2 mt-6 w-full" >
                        <label for="desc" class="font-medium">Description</label>
                        <textarea  id="desc" type="text" rows="4" class="input border-0 bg-base-200 rounded-2xl focus:outline-0 w-full h-38 p-2 font-medium" />
                    </div>
                    <button type="submit" class="btn btn-secondary mt-8 w-full rounded-4xl">
                        Add Task
                    </button>
                </form>
            </div>
            </dialog>  
            <span class="py-2 px-3 bg-base rounded-full  text-base-content hover:bg-neutral/30 transition-all duration-300 ">
                <svg xmlns="http://www.w3.org/2000/svg" height="37px" viewBox="0 -960 960 960" fill="currentColor"><path d="M160-200v-80h80v-280q0-83 50-147.5T420-792v-28q0-25 17.5-42.5T480-880q25 0 42.5 17.5T540-820v28q80 20 130 84.5T720-560v280h80v80H160Zm320-300Zm0 420q-33 0-56.5-23.5T400-160h160q0 33-23.5 56.5T480-80ZM320-280h320v-280q0-66-47-113t-113-47q-66 0-113 47t-47 113v280Z"/></svg>
            </span>
            <div class="dropdown dropdown-end">
                <avatar tabindex="0" role="button" class=" rounded-full"/>
                <div tabindex="0" class="dropdown-content bg-[#ebe8e2] w-40 box mt-2 p-4 font-medium">
                    <p>User ID: {{ userInfo.userID }}</p>
                    <p>Username: {{ userInfo.username }}</p>
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