<template>
    <div class="h-full flex flex-row gap-4">
        <project-task-list  class="w-2/5"/>
        <project-task  class="w-3/5"/>
    </div>
</template>

<script>
import ProjectTaskList from './Projects/ProjectTaskList.vue';
import ProjectTask from './Projects/ProjectTask.vue';

export default {
  components: { 
    ProjectTask,
    ProjectTaskList
  }
}
</script>