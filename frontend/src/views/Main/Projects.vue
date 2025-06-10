<template> 
  <div class="h-full flex flex-col pb-4">
    <div class="flex-1 flex flex-row gap-8 min-h-0">
        <project-task-list class="w-1/3 h-full"/>
        <project-task class="w-2/3 h-full"/>
    </div>
  </div>
</template>

<script>
import ProjectTaskList from './Projects/ProjectTaskList.vue';
import ProjectTask from './Projects/ProjectTask.vue';
import AddProjModal from './Projects/AddProjModal.vue';
import JoinProjectModal from './Projects/JoinProjectModal.vue';

export default {
  components: { 
    ProjectTask,
    ProjectTaskList,
    AddProjModal,
    JoinProjectModal,
  },
  data() {
    return {
      error: '',
      success: ''
    }
  },
  methods: {

  }
}
</script>