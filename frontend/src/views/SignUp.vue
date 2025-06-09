<template>
    <div class="h-screen p-4 flex justify-center items-center">
        <div class="box bg-[#EBE8E2] h-3/5 lg:w-1/2 w-full lg:flex lg:flex-row ">
            <div class="lg:w-3/5 h-full flex flex-col gap-4 justify-center items-center text-center px-4">
                <h1 class="font-bold lg:text-5xl text-4xl mb-8">Create an Account</h1>
                <form class="flex flex-col gap-4 w-full items-center" @submit.prevent="SignUp">
                    <input v-model="form.username" type="text" placeholder="Username" class="input rounded-2xl focus:outline-0 lg:w-3/5 w-9/10 h-12 font-medium" /> 
                    <input v-model="form.email" type="email" placeholder="Email" class="input rounded-2xl focus:outline-0 lg:w-3/5 w-9/10 h-12 font-medium" /> 
                    <input v-model="form.password" type="password" placeholder="Password" class="input rounded-2xl focus:outline-0 lg:w-3/5 w-9/10 h-12 font-medium" /> 
                    <input v-model="form.repPassword" type="password" placeholder="Repeat Password" class="input rounded-2xl focus:outline-0 lg:w-3/5 w-9/10 h-12 font-medium" />
                    <button class="h-12 w-2/5 bg-[#97ddcd] rounded-2xl font-medium mt-4 shadow-md hover-effect" type="submit">Sign Up</button>
                </form>
            </div>
            <div class="hidden w-2/5 bg-[#62d5ba] rounded-r-2xl lg:flex flex-col justify-center items-center text-center gap-8 px-12">
                <h1 class="text-4xl font-bold text-white">Welcome back! </h1>
                <p class="font-medium text-white text-lg ">Sign in to continue tracking your tasks with ease.</p>
                <button class="h-12 w-2/5 border-2 text-white hover-effect border-white rounded-2xl font-medium mt-4" @click="GoToLogIn">Log In</button>
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
                username: '',
                email: '',
                password: '',
                repPassword: ''
            },
            success: '',
            error: '',          
        }
    },
    methods: {
        GoToLogIn() {
            this.$router.push('/login')
        },
        ResetForm() {
            this.form.username = '';
            this.form.email = '';
            this.form.password  = '';
            this.form.repPassword   = '';
        },
        async SignUp() {
            this.error = '';
            this.success = '';

            // ensures that no field is empty
            if (!this.form.username || !this.form.email || !this.form.password || !this.form.repPassword) {
                this.error = 'All fields are required';
                alert(this.error);
                return;
            }
            
            // checks if the passwords match
            if (this.form.password != this.form.repPassword) {
                this.error = 'Passwords didn\'t match';
                alert(this.error);
                return;
            }

            try {
                const res = await axios.post('http://localhost/IPT_FINAL_PROJ/backend/index.php/signup', this.form);
                if(res.data.success){
                    this.success = 'Succesfully Registered!';
                    this.error = '';
                    alert(this.success);
                } else {
                    this.error = res.data.message;
                    this.success = '';
                    alert(this.error);
                }
            } catch(err) {
                this.error = 'An error occured during Sign Up!'
                this.success = '';
                alert(this.error);
            }

            this.ResetForm();
            this.GoToLogIn();
        }
    }
}
</script>