<template>
    <div class="h-full flex flex-col">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-primary/10 to-secondary/10 border-b border-primary/20 p-6 rounded-t-3xl">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-primary/20 rounded-xl">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-black text-3xl text-primary tracking-wide">Change Password</h2>
                    <p class="text-base-content/60 text-sm">Update your account security</p>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 p-6 overflow-y-auto flex justify-center items-center h-full w-full">
            <!-- Step 1: Current Password Verification -->
            <div v-if="currentStep === 'verify'" class="w-3/4 mx-auto ">
                <div class="bg-base-100 rounded-2xl p-6 w-full">
                    <div class="text-center mb-6">
                        <div class="p-4 bg-warning/20 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-base-content mb-2">Security Verification</h3>
                        <p class="text-base-content/60 text-sm">Please enter your current password to continue</p>
                    </div>

                    <form @submit.prevent="verifyCurrentPassword" class="space-y-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Current Password</span>
                            </label>
                            <div class="relative">
                                <input
                                    v-model="currentPassword"
                                    :type="showCurrentPassword ? 'text' : 'password'"
                                    class="input input-bordered w-full pr-12 transition-all duration-300 focus:border-primary focus:shadow-lg"
                                    :class="{ 'input-error': hasCurrentPasswordError }"
                                    placeholder="Enter your current password"
                                    required
                                    :disabled="isVerifying"
                                />
                                <button
                                    type="button"
                                    @click="showCurrentPassword = !showCurrentPassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-base-content/60 hover:text-base-content transition-colors"
                                    :disabled="isVerifying"
                                >
                                    <svg v-if="!showCurrentPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                    </svg>
                                </button>
                            </div>
                            <label v-if="hasCurrentPasswordError" class="label">
                                <span class="label-text-alt text-error">{{ currentPasswordError }}</span>
                            </label>
                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-full transition-all duration-300 hover:shadow-lg hover:scale-[1.02]"
                            :disabled="isVerifying || !currentPassword"
                            :class="{ 'loading': isVerifying }"
                        >
                            <span v-if="!isVerifying">Verify Password</span>
                            <span v-else>Verifying...</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Step 2: New Password Setting -->
            <div v-if="currentStep === 'newPassword'" class="w-3/4 mx-auto">
                <div class=" rounded-2xl p-6    ">
                    <div class="text-center mb-6">
                        <div class="p-4 bg-success/20 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-base-content mb-2">Set New Password</h3>
                        <p class="text-base-content/60 text-sm">Choose a strong password for your account</p>
                    </div>

                    <form @submit.prevent="updatePassword" class="space-y-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">New Password</span>
                            </label>
                            <div class="relative">
                                <input
                                    v-model="newPassword"
                                    :type="showNewPassword ? 'text' : 'password'"
                                    class="input input-bordered w-full pr-12 transition-all duration-300 focus:border-primary focus:shadow-lg"
                                    :class="{ 
                                        'input-error': hasNewPasswordError,
                                        'input-success': newPassword && !hasNewPasswordError
                                    }"
                                    placeholder="Enter your new password"
                                    required
                                    :disabled="isUpdating"
                                />
                                <button
                                    type="button"
                                    @click="showNewPassword = !showNewPassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-base-content/60 hover:text-base-content transition-colors"
                                    :disabled="isUpdating"
                                >
                                    <svg v-if="!showNewPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                    </svg>
                                </button>
                            </div>
                            <label class="label">
                                <span class="label-text-alt" :class="{ 'text-error': hasNewPasswordError, 'text-success': newPassword && !hasNewPasswordError }">
                                    {{ newPasswordHint }}
                                </span>
                            </label>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Confirm New Password</span>
                            </label>
                            <div class="relative">
                                <input
                                    v-model="confirmPassword"
                                    :type="showConfirmPassword ? 'text' : 'password'"
                                    class="input input-bordered w-full pr-12 transition-all duration-300 focus:border-primary focus:shadow-lg"
                                    :class="{ 
                                        'input-error': hasConfirmPasswordError,
                                        'input-success': confirmPassword && !hasConfirmPasswordError
                                    }"
                                    placeholder="Confirm your new password"
                                    required
                                    :disabled="isUpdating"
                                />
                                <button
                                    type="button"
                                    @click="showConfirmPassword = !showConfirmPassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-base-content/60 hover:text-base-content transition-colors"
                                    :disabled="isUpdating"
                                >
                                    <svg v-if="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                    </svg>
                                </button>
                            </div>
                            <label v-if="hasConfirmPasswordError" class="label">
                                <span class="label-text-alt text-error">{{ confirmPasswordError }}</span>
                            </label>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div v-if="newPassword" class="mt-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-base-content/60">Password Strength:</span>
                                <span :class="passwordStrengthClass">{{ passwordStrengthText }}</span>
                            </div>
                            <div class="w-full bg-base-300 rounded-full h-2">
                                <div 
                                    class="h-2 rounded-full transition-all duration-300" 
                                    :class="passwordStrengthBarClass"
                                    :style="{ width: passwordStrengthWidth }"
                                ></div>
                            </div>
                        </div>

                        <div class="flex gap-3 mt-6">
                            <button
                                type="button"
                                @click="goBack"
                                class="btn btn-ghost flex-1 transition-all duration-300 hover:shadow-md"
                                :disabled="isUpdating"
                            >
                                Back
                            </button>
                            <button
                                type="submit"
                                class="btn btn-primary flex-1 transition-all duration-300 hover:shadow-lg hover:scale-[1.02]"
                                :disabled="isUpdating || !isFormValid"
                                :class="{ 'loading': isUpdating }"
                            >
                                <span v-if="!isUpdating">Update Password</span>
                                <span v-else>Updating...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Step 3: Success Message -->
            <div v-if="currentStep === 'success'" class="max-w-md mx-auto text-center">
                <div class="bg-success/10 rounded-2xl p-8 border border-success/20">
                    <div class="p-4 bg-success/20 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                        <svg class="w-10 h-10 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-success mb-3">Password Updated Successfully!</h3>
                    <p class="text-base-content/60 mb-6">Your password has been changed. Please use your new password for future logins.</p>
                    <button
                        @click="resetForm"
                        class="btn btn-primary transition-all duration-300 hover:shadow-lg hover:scale-[1.02]"
                    >
                        Done
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: 'PasswordSettings',
    data() {
        return {
            currentStep: 'verify', // 'verify', 'newPassword', 'success'
            
            // Current password verification
            currentPassword: '',
            showCurrentPassword: false,
            isVerifying: false,
            currentPasswordError: '',
            
            // New password setting
            newPassword: '',
            confirmPassword: '',
            showNewPassword: false,
            showConfirmPassword: false,
            isUpdating: false
        };
    },
    computed: {
        hasCurrentPasswordError() {
            return !!this.currentPasswordError;
        },
        hasNewPasswordError() {
            return this.newPassword && !this.isPasswordValid(this.newPassword);
        },
        hasConfirmPasswordError() {
            return this.confirmPassword && this.newPassword !== this.confirmPassword;
        },
        newPasswordHint() {
            if (!this.newPassword) return 'Password must be at least 8 characters long';
            if (this.hasNewPasswordError) return 'Password must contain uppercase, lowercase, number, and special character';
            return 'Password meets security requirements';
        },
        confirmPasswordError() {
            if (this.hasConfirmPasswordError) return 'Passwords do not match';
            return '';
        },
        isFormValid() {
            return this.newPassword && 
                   this.confirmPassword && 
                   !this.hasNewPasswordError && 
                   !this.hasConfirmPasswordError;
        },
        passwordStrength() {
            if (!this.newPassword) return 0;
            
            let strength = 0;
            const password = this.newPassword;
            
            // Length check
            if (password.length >= 8) strength += 1;
            if (password.length >= 12) strength += 1;
            
            // Character variety checks
            if (/[a-z]/.test(password)) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;
            
            return Math.min(strength, 5);
        },
        passwordStrengthText() {
            const strength = this.passwordStrength;
            if (strength <= 1) return 'Very Weak';
            if (strength === 2) return 'Weak';
            if (strength === 3) return 'Fair';
            if (strength === 4) return 'Good';
            return 'Strong';
        },
        passwordStrengthClass() {
            const strength = this.passwordStrength;
            if (strength <= 1) return 'text-error';
            if (strength === 2) return 'text-warning';
            if (strength === 3) return 'text-info';
            if (strength === 4) return 'text-success';
            return 'text-success font-bold';
        },
        passwordStrengthBarClass() {
            const strength = this.passwordStrength;
            if (strength <= 1) return 'bg-error';
            if (strength === 2) return 'bg-warning';
            if (strength === 3) return 'bg-info';
            if (strength === 4) return 'bg-success';
            return 'bg-success';
        },
        passwordStrengthWidth() {
            return `${(this.passwordStrength / 5) * 100}%`;
        }
    },
    methods: {
        async verifyCurrentPassword() {
            if (!this.currentPassword) return;
            
            this.isVerifying = true;
            this.currentPasswordError = '';
            
            try {
                const user = JSON.parse(localStorage.getItem('user'));
                if (!user.id) {
                    throw new Error('User not authenticated');
                }

                const response = await axios.post('https://act-track.x10.mx/index.php/verify-password', {
                    user_id: user.id,
                    current_password: this.currentPassword
                }, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                
                if (response.data.success) {
                    this.currentStep = 'newPassword';
                } else {
                    throw new Error(response.data.message);
                }
                
            } catch (error) {
                this.currentPasswordError = error.response?.data?.message || 
                                        error.message || 
                                        'Failed to verify password. Please try again.';
            } finally {
                this.isVerifying = false;
            }
        },
        
        async updatePassword() {
            if (!this.isFormValid) return;
            
            this.isUpdating = true;
            
            try {
                const user = JSON.parse(localStorage.getItem('user'));
                if (!user.id) {
                    throw new Error('User not authenticated');
                }

                const response = await axios.post('https://act-track.x10.mx/index.php/update-password', {
                    user_id: user.id,
                    current_password: this.currentPassword,
                    new_password: this.newPassword,
                    confirm_password: this.confirmPassword
                }, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                
                if (response.data.success) {
                    this.currentStep = 'success';
                    // Clear sensitive data
                    this.currentPassword = '';
                    this.newPassword = '';
                    this.confirmPassword = '';
                } else {
                    throw new Error(response.data.message);
                }
                
            } catch (error) {
                const errorMessage = error.response?.data?.message || 
                                error.message || 
                                'Failed to update password. Please try again.';
                
                // Show error to user
                alert(errorMessage);
                
                // If authentication failed
                if (error.response?.data?.requires_reauthentication) {
                    this.currentStep = 'verify';
                    this.currentPasswordError = 'Please verify your password again';
                }
            } finally {
                this.isUpdating = false;
            }
        },
        
        isPasswordValid(password) {
            // Password must be at least 8 characters and contain:
            // - At least one lowercase letter
            // - At least one uppercase letter
            // - At least one number
            // - At least one special character
            const minLength = password.length >= 8;
            const hasLower = /[a-z]/.test(password);
            const hasUpper = /[A-Z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecial = /[^A-Za-z0-9]/.test(password);
            
            return minLength && hasLower && hasUpper && hasNumber && hasSpecial;
        },
        
        goBack() {
            this.currentStep = 'verify';
            this.newPassword = '';
            this.confirmPassword = '';
        },
        
        resetForm() {
            this.currentStep = 'verify';
            this.currentPassword = '';
            this.newPassword = '';
            this.confirmPassword = '';
            this.currentPasswordError = '';
            this.showCurrentPassword = false;
            this.showNewPassword = false;
            this.showConfirmPassword = false;
        },
        
        // Utility function to simulate API calls
        simulateApiCall(delay = 1000) {
            return new Promise((resolve) => {
                setTimeout(resolve, delay);
            });
        }
    }
};
</script>

<style scoped>
/* Smooth transitions for all interactive elements */
* {
    transition: all 0.2s ease-in-out;
}

/* Enhanced input focus effects */
.input:focus {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Button hover effects */
.btn:hover:not(:disabled) {
    transform: translateY(-1px);
}

/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: transparent;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: rgba(156, 163, 175, 0.3);
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: rgba(156, 163, 175, 0.5);
}

/* Enhanced accessibility */
.btn:focus,
.input:focus {
    outline: 2px solid rgba(139, 92, 246, 0.6);
    outline-offset: 2px;
}

/* Loading animation enhancement */
.btn.loading::after {
    border-top-color: currentColor;
    border-right-color: transparent;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .text-3xl {
        font-size: 1.5rem;
    }
    
    .p-6 {
        padding: 1rem;
    }
    
    .max-w-md {
        max-width: 100%;
        padding: 0 1rem;
    }
}
</style>