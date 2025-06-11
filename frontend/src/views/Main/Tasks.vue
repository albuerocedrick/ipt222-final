<template>
    <div class="h-full min-h-0 overflow-y-auto pb-6">  
        <all-tasks />
    </div>
</template>

<script>
import AllTasks from './Tasks/AllTasks.vue'
import TaskByStatus from './Tasks/TaskByStatus.vue'

export default {
    components: {
        AllTasks,
        TaskByStatus
    },
    data() {
        return {
            currentOption: 'By Deadline'
        }
    },
    methods: {
        ChangeDropdown(event) {
            this.currentOption = event.target.value;
        }
    }
}
</script>