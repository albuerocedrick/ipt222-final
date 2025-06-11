<template>
    <div class="h-full flex flex-col">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-primary/10 to-secondary/10 border-b border-primary/20 p-6 rounded-t-3xl">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-primary/20 rounded-xl">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-black text-3xl text-primary tracking-wide">Profile Settings</h2>
                    <p class="text-base-content/60 text-sm">Manage your personal information</p>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 p-6 overflow-y-auto">
            <div class="max-w-4xl mx-auto space-y-8">
                <!-- Profile Picture Section -->
                <div class="bg-gradient-to-r from-primary/5 to-secondary/5 rounded-2xl p-6 border border-primary/10">
                    <h3 class="font-bold text-xl mb-6 text-primary">Profile Picture</h3>
                    
                    <div class="flex items-center gap-6">
                        <!-- Current Avatar -->
                        <div class="relative group">
                            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold text-2xl">
                                    {{ getInitials(userProfile.f_name, userProfile.l_name) }}
                                </span>
                            </div>
                            <div class="absolute inset-0 bg-black/40 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center cursor-pointer"
                                 @click="triggerFileUpload">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Upload Controls -->
                        <div class="flex-1">
                            <p class="font-semibold text-lg mb-2">Change Profile Picture</p>
                            <p class="text-base-content/60 text-sm mb-4">Upload a new avatar from your device</p>
                            <div class="flex gap-3">
                                <button @click="triggerFileUpload" class="btn btn-primary btn-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    Upload New
                                </button>
                                <button v-if="userProfile.avatar" @click="removeAvatar" class="btn btn-ghost btn-sm text-error">
                                    Remove
                                </button>
                            </div>
                            <input type="file" ref="avatarInput" class="hidden" accept="image/*" @change="onAvatarChange">
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="bg-base-100 rounded-2xl p-6 shadow-lg border border-base-300">
                    <h3 class="font-bold text-xl mb-6 text-secondary">Personal Information</h3>
                    
                    <form @submit.prevent="updateProfile" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- First Name -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold">First Name</span>
                                </label>
                                <input 
                                    type="text" 
                                    v-model="userProfile.f_name" 
                                    class="input input-bordered focus:input-primary transition-all duration-300"
                                    :class="{'input-error': errors.firstName}"
                                    placeholder="Enter your first name"
                                />
                                <label v-if="errors.f_name" class="label">
                                    <span class="label-text-alt text-error">{{ errors.f_name }}</span>
                                </label>
                            </div>

                            <!-- Last Name -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold">Last Name</span>
                                </label>
                                <input 
                                    type="text" 
                                    v-model="userProfile.l_name" 
                                    class="input input-bordered focus:input-primary transition-all duration-300"
                                    :class="{'input-error': errors.l_name}"
                                    placeholder="Enter your last name"
                                />
                                <label v-if="errors.l_name" class="label">
                                    <span class="label-text-alt text-error">{{ errors.l_name }}</span>
                                </label>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-control flex flex-col">
                            <label class="label">
                                <span class="label-text font-semibold">Email Address</span>
                            </label>
                            <input 
                                type="email" 
                                v-model="userProfile.email" 
                                class="input input-bordered focus:input-primary transition-all duration-300"
                                :class="{'input-error': errors.email}"
                                placeholder="Enter your email address"
                            />
                            <label v-if="errors.email" class="label">
                                <span class="label-text-alt text-error">{{ errors.email }}</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-4">
                            <button 
                                type="submit" 
                                class="btn bg-gradient-to-r from-success to-success/80 hover:from-success/90 hover:to-success/70 text-success-content border-none shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02] font-bold px-8"
                                :disabled="isUpdating"
                            >
                                <svg v-if="!isUpdating" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span v-if="isUpdating" class="loading loading-spinner loading-sm mr-2"></span>
                                {{ isUpdating ? 'Updating...' : 'Update Profile' }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Account Information -->
                <div class="bg-gradient-to-r from-info/5 to-info/10 rounded-2xl p-6 border border-info/20">
                    <h3 class="font-bold text-xl mb-6 text-info">Account Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-white/50 rounded-xl">
                                <span class="font-semibold text-base-content/70">Member Since</span>
                                <span class="font-bold">{{ formatDate(userProfile.created_at) }}</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-white/50 rounded-xl">
                                <span class="font-semibold text-base-content/70">User ID</span>
                                <span class="font-mono text-sm">{{ userProfile.user_id }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ProfileSettings',
    data() {
        return {
            isUpdating: false,
            userProfile: {
                user_id: '',
                f_name: '',
                l_name: '',
                email: '',
                avatar: null,
                created_at: '',
            },
            errors: {}
        };
    },
    methods: {
        getInitials(firstName, lastName) {
            return `${firstName?.charAt(0) || ''}${lastName?.charAt(0) || ''}`.toUpperCase();
        },

        triggerFileUpload() {
            this.$refs.avatarInput.click();
        },

        onAvatarChange(event) {
            const file = event.target.files[0];
            if (file) {
                if (file.size > 5 * 1024 * 1024) { // 5MB limit
                    alert('File size must be less than 5MB');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.userProfile.avatar = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        removeAvatar() {
            this.userProfile.avatar = null;
        },

        validateForm() {
            this.errors = {};
            
            if (!this.userProfile.f_name.trim()) {
                this.errors.firstName = 'First name is required';
            }
            
            if (!this.userProfile.l_name.trim()) {
                this.errors.lastName = 'Last name is required';
            }
            
            if (!this.userProfile.email.trim()) {
                this.errors.email = 'Email is required';
            } else if (!this.isValidEmail(this.userProfile.email)) {
                this.errors.email = 'Please enter a valid email address';
            }
            
            return Object.keys(this.errors).length === 0;
        },

        isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        },

        async updateProfile() {
            if (!this.validateForm()) {
                return;
            }

            this.isUpdating = true;
            try {
                // Call the actual API endpoint
                const response = await axios.put('http://localhost/IPT_FINAL_PROJ/backend/index.php/update-profile', {
                    user_id: this.userProfile.user_id,
                    f_name: this.userProfile.f_name,
                    l_name: this.userProfile.l_name,
                    email: this.userProfile.email
                });

                if (response.data.success) {
                    // Update local storage with new data
                    const updatedUser = {
                        ...JSON.parse(localStorage.getItem('user')),
                        f_name: this.userProfile.f_name,
                        l_name: this.userProfile.l_name,
                        email: this.userProfile.email
                    };
                    localStorage.setItem('user', JSON.stringify(updatedUser));
                    
                    this.showSuccessMessage(response.data.message);
                } else {
                    throw new Error(response.data.message || 'Failed to update profile');
                }
                
            } catch (error) {
                console.error('Error updating profile:', error);
                this.showErrorMessage(error.response?.data?.message || 'Error updating profile. Please try again.');
            } finally {
                this.isUpdating = false;
            }
        },

        showSuccessMessage(message) {
            alert(message); // Consider using a toast notification library instead
        },

        showErrorMessage(message) {
            alert(message); // Consider using a toast notification library instead
        },

        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }
    },
    mounted() {
        const user = JSON.parse(localStorage.getItem('user'));

        if (user) {
            this.userProfile = {
                user_id: user.id,
                f_name: user.f_name,
                l_name: user.l_name,
                email: user.email,
                created_at: user.created_at,
                avatar: user.profile_pic || null
            };
        }
    }
};
</script>

<style scoped>
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

/* Enhanced form transitions */
.input:focus,
.textarea:focus {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Button hover effects */
.btn:hover {
    transform: translateY(-1px);
}

/* Avatar hover effects */
.group .absolute {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Enhanced accessibility */
.btn:focus,
.input:focus,
.textarea:focus {
    outline: 2px solid rgba(139, 92, 246, 0.6);
    outline-offset: 2px;
}

/* Responsive design */
@media (max-width: 768px) {
    .grid-cols-2 {
        grid-template-columns: 1fr;
    }
    
    .p-6 {
        padding: 1rem;
    }
    
    .gap-6 {
        gap: 1rem;
    }
}
</style>