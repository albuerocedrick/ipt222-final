<template> 
  <div class="h-full flex flex-col ">
    <div class="h-14">
      <add-proj-modal />
    </div>
    <div class="h-full flex flex-row gap-4">
        <project-task-list  class="w-2/5"/>
        <project-task  class="w-3/5"/>
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