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

<!-- <template>
    <div
          class="grid grid-cols-4 grid-rows-4 gap-4">
            <MiniCompletedTask 
              class="cols-span-1 row-span-1 bg-green-400" 
              :class="theme.border"/>
            <MiniPendingTaskVue
              class="cols-span-1 row-span-1 bg-red-400"
              :class="theme.border"   />
            <MiniCalendar 
                class="col-span-2 row-span-2"
                :class="theme.cardBg"
                :theme="theme"
                />
            <MiniUpcomingDeadline
              class="col-span-2 row-span-3"
              :class="theme.cardBg" 
              :theme="theme"
              @clickMenu="forwardClickMenu"/>
            <div class="col-span-2 row-span-2 grid grid-cols-2 grid-rows-2 gap-4">
                <MiniProjectList
                  class="row-span-2 col-span-1"
                  :class="theme.cardBg" 
                  :theme="theme"
                  @clickMenu="forwardClickMenu"/>
                <MiniMissedTask 
                  class="row-span-2 col-span-1"
                  :class="theme.cardBg"
                  :theme="theme"/>
            </div>
        </div>
</template> -->