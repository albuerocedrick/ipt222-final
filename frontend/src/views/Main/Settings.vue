<template>
    <div class="flex flex-row w-full h-full gap-8">
        <setting-menu />
        <setting-content />
    </div>
</template>

<script>
import SettingMenu from './SettingsPage/SettingMenu.vue';
import SettingContent from './SettingsPage/SettingContent.vue';

export default {
    components: {
        SettingMenu,
        SettingContent
    }
}
</script>