<template>
    <div class="h-full min-h-0 overflow-hidden">     
       <dropdown />
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