<template>
    <div class="p-4">
        <nav-bar />
        <hero-section />
        <features />
    </div>
</template>

<script>
import NavBar from '../components/NavBar.vue';
import HeroSection from './LandingPage/HeroSection.vue';
import Features from './LandingPage/Features.vue';

export default {
    components: {
        NavBar,
        HeroSection,
        Features
    }
}
</script>