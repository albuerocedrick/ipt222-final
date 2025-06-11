<template>
    <div class="min-h-screen bg-gradient-to-br from-base-200 to-base-300 p-4 flex justify-center items-center">
        <div class="card bg-base-100 shadow-2xl max-w-4xl w-full lg:card-side overflow-hidden box">
            <!-- Login Form Section -->
            <div class="card-body lg:w-3/5 flex flex-col justify-center px-8 py-12">
                <div class="text-center mb-8">
                    <h1 class="text-4xl lg:text-5xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-2">
                        Welcome Back
                    </h1>
                    <p class="text-base-content/70 text-lg">Sign in to your account</p>
                </div>
                
                <form class="space-y-6" @submit.prevent="Login">
                    <!-- Email Field -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Email Address</span>
                        </label>
                        <input 
                            v-model="form.email" 
                            type="email" 
                            placeholder="Enter your email" 
                            class="input input-bordered input-primary w-full bg-base-200/50 backdrop-blur-sm focus:bg-base-100 transition-all duration-200 hover:shadow-md" 
                            required
                        />
                    </div>
                    
                    <!-- Password Field -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Password</span>
                        </label>
                        <input 
                            v-model="form.password" 
                            type="password" 
                            placeholder="Enter your password" 
                            class="input input-bordered input-primary w-full bg-base-200/50 backdrop-blur-sm focus:bg-base-100 transition-all duration-200 hover:shadow-md" 
                            required
                        />
                        <label class="label mt-2">
                            <a href="#" class="label-text-alt link link-primary hover:link-hover">Forgot password?</a>
                        </label>
                    </div>
                    
                    <!-- Remember Me -->
                    <!-- <div class="form-control">
                        <label class="cursor-pointer label justify-start gap-3">
                            <input type="checkbox" class="checkbox checkbox-primary checkbox-sm" />
                            <span class="label-text">Remember me</span>
                        </label>
                    </div> -->
                    
                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="btn btn-primary w-full h-12 text-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Sign In
                    </button>
                </form>
                
                <!-- Social Login -->
                <!-- <div class="divider my-6">OR</div>
                <div class="space-y-3">
                    <button class="btn btn-outline btn-neutral w-full">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Continue with Google
                    </button>
                    <button class="btn btn-outline btn-neutral w-full">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Continue with Facebook
                    </button>
                </div> -->
            </div>
            
            <!-- Welcome New User Section -->
            <div class="bg-gradient-to-br from-primary to-secondary text-primary-content lg:w-2/5 hidden lg:flex flex-col justify-center items-center text-center p-12 relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-10 right-10 w-24 h-24 border-2 border-current rounded-full"></div>
                    <div class="absolute bottom-16 left-8 w-16 h-16 border-2 border-current rounded-lg rotate-12"></div>
                    <div class="absolute top-1/3 left-6 w-8 h-8 border-2 border-current rounded-full"></div>
                    <div class="absolute bottom-1/3 right-6 w-12 h-12 border-2 border-current rounded-lg rotate-45"></div>
                </div>
                
                <div class="relative z-10 space-y-6">
                    
                    <h2 class="text-3xl lg:text-4xl font-bold leading-tight">
                        New to Assignment & Activity Tracker?
                    </h2>
                    <p class="text-lg opacity-90 leading-relaxed max-w-sm">
                        Join other users who manage their tasks efficiently. Create your account and start organizing your productivity journey today.
                    </p>
                    
                    
                    
                    <button 
                        class="btn btn-outline btn-primary-content hover:bg-primary-content hover:text-primary transition-all duration-200 transform hover:scale-105 mt-8 px-8" 
                        @click="GoToSignUp"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Create Account
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Sign Up Link -->
        <div class="fixed bottom-4 left-4 right-4 lg:hidden">
            <div class="card bg-base-100/90 backdrop-blur-sm shadow-lg">
                <div class="card-body py-4 text-center">
                    <p class="text-sm text-base-content/70 mb-2">Don't have an account?</p>
                    <button class="btn btn-outline btn-primary btn-sm" @click="GoToSignUp">Create Account</button>
                </div>
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
                f_name: '',
                l_name: '',
                email: '',
                created_at: '',
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
                    this.user.f_name = user.f_name;
                    this.user.l_name = user.l_name;
                    this.user.email = user.email;
                    this.user.created_at = user.created_at;

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