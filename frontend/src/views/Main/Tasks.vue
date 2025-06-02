<template>
    <div class="h-full ">     
        <dropdown />
        <task-table />
    </div>
</template>

<script>
import Dropdown from './Tasks/Dropdown.vue';
import TaskTable from './Tasks/TaskTable.vue';

export default {
    components: {
        Dropdown,
        TaskTable
    }
}
</script>