<template>
    <div class="h-screen px-4 pt-4 grid grid-rows-[80px_1fr] grid-cols-[300px_1fr] gap-4">
        <nav-bar class="col-span-2"/>
        <side-bar class="row-span-2"/>
        <div>
            <router-view />
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