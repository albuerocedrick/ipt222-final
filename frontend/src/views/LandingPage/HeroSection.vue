<template>
    <div class="flex md:flex-row flex-col box my-4 h-screen bg-[#EBE8E2]">
        <div class="flex-1 flex flex-col justify-center items-center text-center gap-8 lg:px-28 md:px-20 px-8">
            <h1 :class="['text-3xl', ' md:text-5xl ', 'font-bold mt-4']">Streamline Your Tasks and Collaborate Effortlessly with Assignment and Activity Tracker</h1>
            <p :class="['text-sm', 'md:text-xl',]">A powerful task management tool that allows you to seamlessly collaborate with others. By giving selective access, other users can assign tasks to you, helping you stay on top of your assignments and activities in real-time.</p>
            <button class="md:w-2xs md:h-16 h-12 w-3/5 rounded-xl text-white bg-[#7a6ca3] font-medium shadow hover-effect" @click="GoToSignUp"> Get Started</button>       
        </div>
        <div class="flex-1 flex justify-center items-center mb-12">
            <img src="../../assets/clipboard.png" alt="clipboard image">
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