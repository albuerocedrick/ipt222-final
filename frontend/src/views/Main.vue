<template>
    <div class="h-screen px-4 py-4 grid grid-rows-[80px_1fr] grid-cols-[350px_1fr] gap-8 overflow-hidden">
        <side-bar class="row-span-2"/>
        <nav-bar class="col-span-1"/>
        <div class="overflow-hidden min-h-0 h-full">
            <router-view class="h-full max-h-full"/>
        </div>
    </div>
</template>

<script>
import NavBar from '../components/NavBar.vue';
import SideBar from './Main/SideBar.vue';

export default {
    components: {
        NavBar,
        SideBar,
    }
}
</script>