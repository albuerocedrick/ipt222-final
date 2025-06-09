<template>
    <div class="flex flex-col h-full box bg-[#ebe8e2] overflow-y-auto">
        <div class="flex flex-row justify-between mb-4 bg-[#62d5ba] rounded-t-2xl h-20 items-center px-4"> 
            <p :class="['font-semibold text-2xl']">Tasks</p>
        </div>
        <div v-for="(task, index) in tasks" :key="index" class="h-20 rounded-2xl border border-gray-400 p-4 mx-4 shadow-sm mb-2 flex flex-row justify-between items-center bg-base-300">
                <p class="font-medium text-xl whitespace-nowrap overflow-hidden text-ellipsis ">{{ task.title }}</p>
            <div :class="['badge badge-outline border-2', 
                        {'!border-yellow-500 text-yellow-500': task.status == 'Near Deadline'},
                        {'!border-blue-500 text-blue-500': task.status == 'Not Started'},
                        {'!border-gray-500 text-gray-500': task.status == 'In Progress'},
                        {'!border-orange-500 text-orange-500': task.status == 'Finished Late'},
                        {'!border-green-500 text-green-500': task.status == 'Done'},
                        {'!border-red-500 text-red-500': task.status == 'Missed'},
                        ]">
                {{ task.status }}
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            tasks: []
        }
    },
    mounted() {
        this.$bus.$on("FetchTasksByProj", this.FetchTasksByProj);
    },
    beforeUnmount() {
        this.$bus.$off("FetchTasksByProj", this.FetchTasksByProj);
    },
    methods: {
        async FetchTasksByProj(project_id) {
            const res = await axios.get('http://localhost/IPT_FINAL_PROJ/backend/index.php/fetchtaskbyprojid',{params:{ project_id: project_id}});

            if(res.data.success) {
                this.tasks = res.data.data;
            } else {
                this.error = 'Something went wrong during fetch';
                this.success = '';
                alert(this.error);
            }
        }
    }
}

</script>