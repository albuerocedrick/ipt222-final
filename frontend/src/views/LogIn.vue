<template>
    <div class="h-screen p-4 flex justify-center items-center">
        <div class="box bg-base-100 h-3/5 lg:w-1/2 lg:flex lg:flex-row">
            <div class="lg:w-3/5 h-full flex flex-col gap-4 justify-center items-center text-center text-base-content">
                <h1 class="font-bold text-4xl mb-8">Login to your Account</h1>
                <form class="flex flex-col w-full items-center gap-4" @submit.prevent="Login">
                    <input v-model="form.email" type="email" placeholder="Email" class="input rounded-2xl focus:outline-0 lg:w-3/5 w-9/10 h-12 font-medium bg-base-200" /> 
                    <input v-model="form.password" type="password" placeholder="Password" class="input rounded-2xl focus:outline-0 lg:w-3/5 w-9/10 h-12 font-medium bg-base-200" /> 
                    <button type="submit" class="h-12 w-2/5 bg-primary text-primary-content shadow-md rounded-2xl font-medium mt-4 hover-effect">Log In</button>
                </form>
            </div>
            <div class="hidden w-2/5 bg-primary rounded-r-4xl lg:flex flex-col justify-center items-center text-center gap-8 px-12 text-primary-content">
                <h1 class="text-4xl font-bold ">New to Assignment and Activity Tracker? </h1>
                <p class="font-medium  text-lg ">Create an account and manage your tasks with ease.</p>
                <button class="h-12 w-2/5 border-2  border-primary-content rounded-2xl font-medium mt-4 hover-effect" @click="GoToSignUp">Sign Up</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            user: {
                id: '',
                email: '',
                created_at: '',
                username: ''
            },
            error: '',
            success: ''
        }
    },
    methods: {
        GoToSignUp() {
            this.$router.push('/signup')
        },
        ResetForm() {
            this.form.email = '';
            this.form.password = '';
        },
        async Login() {
            const res = await axios.post('http://localhost/IPT_FINAL_PROJ/backend/index.php/login', this.form);

            try {
                if(res.data.success) {
                    const user = res.data.user;

                    // gets the user data and add it  to the local storage
                    this.user.id = user.user_id;
                    this.user.email = user.email;
                    this.user.created_at = user.created_at;
                    this.user.username = user.username;

                    localStorage.setItem('user', JSON.stringify(this.user));
                    
                    this.success = res.data.message;
                    this.error = '';
                    alert(this.success);

                    this.ResetForm();

                    this.$router.push('/main');
                } else {
                    this.error = res.data.message;
                    this.success = '';
                    alert(this.success);
                }
            } catch(err) {
                this.error = 'An error occured during Log In!';
                this.success = '';
                alert(this.error);
            }
        }
    }
}

</script>

<style scoped>
@import "tailwindcss";

/* Custom animations for better performance */
@keyframes gentle-float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.animate-gentle-float {
    animation: gentle-float 3s ease-in-out infinite;
}

/* Ensure focus states work properly */
input:focus {
    outline: none;
}

/* Custom scrollbar for webkit browsers */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: rgba(80, 185, 161, 0.5);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(80, 185, 161, 0.7);
}
</style>