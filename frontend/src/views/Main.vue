<template>
    <div class="h-screen px-4 pt-4 grid grid-rows-[80px_1fr] grid-cols-[300px_1fr] gap-4 overflow-hidden">
        <nav-bar class="col-span-2"/>
        <side-bar class="row-span-2"/>
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