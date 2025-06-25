<template>
    <div class="flex flex-row w-full h-full gap-8">
        <!-- Left Side - Settings Menu -->
        <setting-menu @menu-selected="handleMenuSelection" />
        
        <!-- Right Side - Content Area -->
        <div class="flex-1 bg-base-100 rounded-3xl shadow-2xl border border-primary/10 h-full overflow-hidden">
            <!-- Dynamic Content Based on Selected Menu -->
            <profile-settings v-if="selectedMenu === 'profile'" />
            <password-settings v-if="selectedMenu === 'password'" />
            <!-- <theme-settings v-if="selectedMenu === 'theme'" /> -->
        </div>
    </div>
</template>

<script>
import SettingMenu from './SettingsPage/SettingMenu.vue';
import ProfileSettings from './SettingsPage/ProfileSettings.vue';
import PasswordSettings from './SettingsPage/PasswordSettings.vue';
// import ThemeSettings from './SettingsPage/ThemeSettings.vue';

export default {
    name: 'Settings',
    components: {
        SettingMenu,
        ProfileSettings,
        PasswordSettings,
        // ThemeSettings
    },
    data() {
        return {
            selectedMenu: 'profile' // Default to profile
        };
    },
    methods: {
        handleMenuSelection(menuId) {
            this.selectedMenu = menuId;
        }
    }
};
</script>