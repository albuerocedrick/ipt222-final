<template>
    <div class="h-full grid grid-cols-4 grid-rows-4 gap-4 ">
        <total-completed-task />
        <total-pending-tasks />
        <mini-calendar />
        <upcoming-deadline/>
        <project-list />
        <missed-task />
    </div>
</template>

<script>
import TotalCompletedTask from './Dashboard/TotalCompletedTask.vue'
import TotalPendingTasks from './Dashboard/TotalPendingTasks.vue'
import MiniCalendar from './Dashboard/MiniCalendar.vue';
import UpcomingDeadline from './Dashboard/UpcomingDeadline.vue';
import ProjectList from './Dashboard/ProjectList.vue';
import MissedTask from './Dashboard/MissedTask.vue';

export default {
    components: {
        TotalCompletedTask,
        TotalPendingTasks,
        MiniCalendar,
        UpcomingDeadline,
        ProjectList,
        MissedTask
    }
}
</script>