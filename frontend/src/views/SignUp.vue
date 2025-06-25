<template>
    <div class="min-h-screen bg-gradient-to-br from-base-200 to-base-300 p-4 flex justify-center items-center">
        <div class="card bg-base-100 shadow-2xl max-w-4xl w-full lg:card-side overflow-hidden box">
            <!-- Sign Up Form Section -->
            <div class="card-body lg:w-3/5 flex flex-col justify-center px-8 py-12">
                <div class="text-center mb-8">
                    <h1 class="text-4xl lg:text-5xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-2">
                        Create Account
                    </h1>
                    <p class="text-base-content/70 text-lg">Join us and start your journey</p>
                </div>
                
                <form class="space-y-4" @submit.prevent="SignUp">
                    <!-- Name Fields Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <input 
                                v-model="form.fname" 
                                type="text" 
                                placeholder="First Name" 
                                class="input input-bordered input-primary w-full bg-base-200/50 backdrop-blur-sm focus:bg-base-100 transition-all duration-200 hover:shadow-md" 
                                required
                            />
                        </div>
                        <div class="form-control">
                            <input 
                                v-model="form.lname" 
                                type="text" 
                                placeholder="Last Name" 
                                class="input input-bordered input-primary w-full bg-base-200/50 backdrop-blur-sm focus:bg-base-100 transition-all duration-200 hover:shadow-md" 
                                required
                            />
                        </div>
                    </div>
                    
                    <!-- Email Field -->
                    <div class="form-control">
                        <input 
                            v-model="form.email" 
                            type="email" 
                            placeholder="Email Address" 
                            class="input input-bordered input-primary w-full bg-base-200/50 backdrop-blur-sm focus:bg-base-100 transition-all duration-200 hover:shadow-md" 
                            required
                        />
                    </div>
                    
                    <!-- Password Fields -->
                    <div class="space-y-4">
                        <div class="form-control">
                            <input 
                                v-model="form.password" 
                                type="password" 
                                placeholder="Password" 
                                class="input input-bordered input-primary w-full bg-base-200/50 backdrop-blur-sm focus:bg-base-100 transition-all duration-200 hover:shadow-md" 
                                required
                            />
                        </div>
                        <!-- Password Requirements -->
                        <div v-if="form.password" class="mt-4 space-y-2">
                            <div class="text-sm text-base-content/70 mb-2">Password Requirements:</div>
                            <div class="flex items-center">
                                <span class="w-6 text-center">
                                    <span :class="form.password.length >= 8 ? 'text-success' : 'text-error'">
                                        {{ form.password.length >= 8 ? '✓' : '✗' }}
                                    </span>
                                </span>
                                <span class="text-sm ml-2">At least 8 characters</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-6 text-center">
                                    <span :class="/[A-Z]/.test(form.password) ? 'text-success' : 'text-error'">
                                        {{ /[A-Z]/.test(form.password) ? '✓' : '✗' }}
                                    </span>
                                </span>
                                <span class="text-sm ml-2">At least one uppercase letter</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-6 text-center">
                                    <span :class="/[a-z]/.test(form.password) ? 'text-success' : 'text-error'">
                                        {{ /[a-z]/.test(form.password) ? '✓' : '✗' }}
                                    </span>
                                </span>
                                <span class="text-sm ml-2">At least one lowercase letter</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-6 text-center">
                                    <span :class="/[0-9]/.test(form.password) ? 'text-success' : 'text-error'">
                                        {{ /[0-9]/.test(form.password) ? '✓' : '✗' }}
                                    </span>
                                </span>
                                <span class="text-sm ml-2">At least one number</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-6 text-center">
                                    <span :class="/[^A-Za-z0-9]/.test(form.password) ? 'text-success' : 'text-error'">
                                        {{ /[^A-Za-z0-9]/.test(form.password) ? '✓' : '✗' }}
                                    </span>
                                </span>
                                <span class="text-sm ml-2">At least one special character</span>
                            </div>
                        </div>
                        <div class="form-control">
                            <input 
                                v-model="form.repPassword" 
                                type="password" 
                                placeholder="Confirm Password" 
                                class="input input-bordered input-primary w-full bg-base-200/50 backdrop-blur-sm focus:bg-base-100 transition-all duration-200 hover:shadow-md" 
                                required
                            />
                        </div>
                    </div>
                    
            
                    <!-- Submit Button -->
                    <button 
                        class="btn btn-primary w-full mt-6 h-12 text-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200" 
                        type="submit"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Create Account
                    </button>
                </form>
                
                
            </div>
            
            <!-- Welcome Back Section -->
            <div class="bg-gradient-to-br from-primary to-secondary text-primary-content lg:w-2/5 hidden lg:flex flex-col justify-center items-center text-center p-12 relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-10 left-10 w-20 h-20 border-2 border-current rounded-full"></div>
                    <div class="absolute bottom-20 right-10 w-16 h-16 border-2 border-current rounded-lg rotate-45"></div>
                    <div class="absolute top-1/2 left-5 w-12 h-12 border-2 border-current rounded-full"></div>
                </div>
                
                <div class="relative z-10 space-y-6">
                    
                    <h2 class="text-4xl font-bold mb-4">Welcome Back!</h2>
                    <p class="text-lg opacity-90 leading-relaxed max-w-xs">
                        Already have an account? Sign in to continue your productivity journey with us.
                    </p>
                    
                    <button 
                        class="btn btn-outline btn-primary-content hover:bg-primary-content hover:text-primary transition-all duration-200 transform hover:scale-105 mt-8 px-8" 
                        @click="GoToLogIn"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Sign In
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Sign In Link -->
        <div class="fixed bottom-4 left-4 right-4 lg:hidden">
            <div class="card bg-base-100/90 backdrop-blur-sm shadow-lg">
                <div class="card-body py-4 text-center">
                    <p class="text-sm text-base-content/70 mb-2">Already have an account?</p>
                    <button class="btn btn-outline btn-primary btn-sm" @click="GoToLogIn">Sign In</button>
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
                fname: '',
                lname: '',
                email: '',
                password: '',
                repPassword: ''
            },
            success: '',
            error: '',          
        }
    },
    computed: {
        computed: {
    // ... keep your existing computed properties ...
    
            passwordRequirements() {
                if (!this.form.password) return {};
                return {
                    length: this.form.password.length >= 8,
                    uppercase: /[A-Z]/.test(this.form.password),
                    lowercase: /[a-z]/.test(this.form.password),
                    number: /[0-9]/.test(this.form.password),
                    specialChar: /[^A-Za-z0-9]/.test(this.form.password)
                };
            },
            isPasswordValid() {
                return Object.values(this.passwordRequirements).every(Boolean);
            },
            newPasswordHint() {
                if (!this.form.password) return 'Enter a new password';
                const passed = Object.values(this.passwordRequirements).filter(Boolean).length;
                const total = Object.keys(this.passwordRequirements).length;
                return `Meets ${passed} of ${total} requirements`;
            },
            isFormValid() {
                return this.form.password && 
                    this.confirmPassword && 
                    this.form.password === this.form.repPassword &&
                    this.isPasswordValid;
            }
        }
    },
    methods: {
        GoToLogIn() {
            this.$router.push('/login')
        },
        ResetForm() {
            this.form.fname = '';
            this.form.lname = '';
            this.form.email = '';
            this.form.password  = '';
            this.form.repPassword   = '';
        },
        isPasswordValid(password) {
            // This can now be simplified since we're using passwordRequirements
            const requirements = this.passwordRequirements;
            return requirements.length && 
                requirements.uppercase && 
                requirements.lowercase && 
                requirements.number && 
                requirements.specialChar;
        },
        // Replace your SignUp method with this debug version:

async SignUp() {
    this.error = '';
    this.success = '';

    // ensures that no field is empty
    if (!this.form.fname || !this.form.lname || !this.form.email || !this.form.password || !this.form.repPassword) {
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

    console.log('Form data being sent:', this.form); // DEBUG

    try {
        const res = await axios.post('https://act-track.x10.mx/index.php/signup', this.form);
        
        console.log('Full response:', res); // DEBUG
        console.log('Response data:', res.data); // DEBUG
        console.log('Response status:', res.status); // DEBUG
        
        // Check if res.data exists
        if (!res.data) {
            alert('No response data received from server');
            return;
        }
        
        if (res.data.success) {
            this.success = res.data.message || 'Successfully Registered!';
            this.error = '';
            alert(this.success);
            this.GoToLogIn();
        } else {
            this.error = res.data.message || 'Unknown error occurred';
            this.success = '';
            alert(this.error);
        }
    } catch(err) {
        console.error('Full error object:', err); // DEBUG
        console.error('Error response:', err.response); // DEBUG
        
        if (err.response) {
            console.error('Error response data:', err.response.data); // DEBUG
            console.error('Error response status:', err.response.status); // DEBUG
            
            this.error = err.response.data?.message || 'Server error occurred';
        } else if (err.request) {
            console.error('No response received:', err.request); // DEBUG
            this.error = 'No response from server. Check if backend is running.';
        } else {
            console.error('Request setup error:', err.message); // DEBUG
            this.error = 'Request setup error: ' + err.message;
        }
        
        this.success = '';
        alert(this.error);
    }

    this.ResetForm();
}
    }
}
</script>