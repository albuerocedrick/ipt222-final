<template> 
  <div class="h-full flex flex-col">
    <div class="flex-shrink-0">
      <add-proj-modal />
    </div>
    <div class="flex-1 flex flex-row gap-4 min-h-0">
        <project-task-list class="w-2/5 h-full"/>
        <project-task class="w-3/5 h-full"/>
    </div>
  </div>
</template>

<script>
import ProjectTaskList from './Projects/ProjectTaskList.vue';
import ProjectTask from './Projects/ProjectTask.vue';
import AddProjModal from './Projects/AddProjModal.vue';

export default {
  components: { 
    ProjectTask,
    ProjectTaskList,
    AddProjModal,
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