<template>
<div :class=" [ 'h-20', 'box', 'flex', 'flex-row', 'items-center', 'justify-between', 'bg-[#EBE8E2]']">
        <h1 :class="['font-bold', 'lg:text-2xl md:text-xl text-sm', 'm-8', 'text-black']">  Assignment and Activity Tracker</h1>
        <ul v-if="$route.path === '/'" class="flex flex-row justify-evenly lg:w-1/7 w-3/8">
            <li
              v-for="(page, index) in pages"
              :key="index">
                <router-link
                  :to="page.url"
                  :class="['font-medium text-sm ', {' px-4 py-4 rounded-md bg-blue-500 text-white': page.label === 'Sign Up'}]"> {{ page.label }} </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
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
            ]
        }
    }
}
</script>