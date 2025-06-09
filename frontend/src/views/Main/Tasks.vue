<template>
    <div class="h-full min-h-0 overflow-y-auto">     
       <dropdown />
       <task-by-deadline v-if="currentOption === 'By Deadline'"/>
       <task-by-status v-if="currentOption === 'By Status'"/>
    </div>
</template>

<script>
import Dropdown from './Tasks/Dropdown.vue';
import TaskTable from './Tasks/TaskTable.vue';
import TaskByDeadline from './Tasks/TaskByDeadline.vue'
import TaskByStatus from './Tasks/TaskByStatus.vue'

export default {
    components: {
        Dropdown,
        TaskTable,
        TaskByDeadline,
        TaskByStatus
    },
    data() {
        return {
            currentOption: 'By Deadline'
        }
    },
    methods: {
        DropdownClick(option) {
            this.currentOption = option;
        }
    },
    mounted() {
        this.$bus.$on("ClickDropdown", this.DropdownClick)
    },
    beforeUnmount() {
        this.$bus.$off("ClickDropdown", this.DropdownClick)
    }
}
</script>