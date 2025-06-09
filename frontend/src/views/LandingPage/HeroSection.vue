<template>
    <div class="flex md:flex-row flex-col box my-4 h-[87vh] bg-base-100">
        <div class="flex-1 flex flex-col justify-center items-center text-center gap-8 lg:px-28 md:px-20 px-8 text-base-content">
            <h1 :class="['text-3xl', ' md:text-6xl ', 'font-bold mt-4']">Streamline Your Tasks and Collaborate Effortlessly with Assignment and Activity Tracker</h1>
            <p :class="['text-sm', 'md:text-lg',]">A powerful task management tool that allows you to seamlessly collaborate with others. By giving selective access, other users can assign tasks to you, helping you stay on top of your assignments and activities in real-time.</p>
            <button class="md:w-2xs md:h-16 h-12 w-3/5 rounded-xl text-base-100 text-xl bg-primary font-medium shadow-md hover-effect" @click="GoToSignUp"> Get Started</button>       
        </div>
        <div class="flex-1 flex justify-center items-center mb-12">
            <img src="../../assets/images/Accept tasks-pana (1).png" alt="clipboard image" class="w-150">
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        GoToSignUp() {
            this.$router.push('/signup')
        }
    }
}

</script>