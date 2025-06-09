<template>
    <div class="h-full grid grid-cols-[25%_15%_15%_1fr]  grid-rows-[25%_15%_10%_1fr] gap-8 pb-4">
        <mini-calendar />
        <total-completed-task />
        <total-pending-tasks />
        <missed-task />
        <upcoming-deadline/>
        <project-list />
        <recent-notif />
    </div>
</template>

<script>
import TotalCompletedTask from './Dashboard/TotalCompletedTask.vue'
import TotalPendingTasks from './Dashboard/TotalPendingTasks.vue'
import MiniCalendar from './Dashboard/MiniCalendar.vue';
import UpcomingDeadline from './Dashboard/UpcomingDeadline.vue';
import ProjectList from './Dashboard/ProjectList.vue';
import MissedTask from './Dashboard/MissedTask.vue';
import Timer from './Dashboard/Timer.vue';
import RecentNotif from './Dashboard/RecentNotif.vue'

export default {
    components: {
        TotalCompletedTask,
        TotalPendingTasks,
        MiniCalendar,
        UpcomingDeadline,
        ProjectList,
        MissedTask,
        Timer,
        RecentNotif
    }
}
</script>