<template>
    <div class="h-full min-h-0 overflow-hidden rounded-box border border-base-content/5 bg-[#ebe8e2] box flex flex-col">
        <table class="table table-fixed w-full">
            <!-- head -->
            <thead class="bg-[#62d5ba] sticky top-0 z-10">
                <tr class="text-black">
                    <th class="w-1/5">Title</th>
                    <th class="w-1/5">Status</th>
                    <th class="w-1/5">Project</th>
                    <th class="w-1/5">Start Date</th>
                    <th class="w-1/5">Deadline</th>
                </tr>
            </thead>
        </table>
        <div class="flex-1 overflow-y-auto">
            <table class="table table-fixed w-full">
                <tbody>
                    <tr v-for="table in tables" :key="table.task_id" >
                        <td class="w-1/5">{{ table.title }}</td>
                        <td class="w-1/5">
                            <div :class="['badge badge-outline border-2',
                                    {'!border-yellow-500 text-yellow-500': table.status === 'Near Deadline'},
                                    {'!border-blue-500 text-blue-500': table.status === 'Not Started'},
                                    {'!border-gray-500 text-gray-500': table.status === 'In Progress'},
                                    {'!border-orange-500 text-orange-500': table.status === 'Finished Late'},
                                    {'!border-green-500 text-green-500': table.status === 'Done'},
                                    {'!border-red-500 text-red-500': table.status === 'Missed'},
                                ]">
                                {{ table.status }}
                            </div>
                        </td>
                        <td class="w-1/5">{{ table.project_name }}</td>
                        <td class="w-1/5">{{ table.start_date }}</td>
                        <td class="w-1/5">{{ table.due_date }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>


<script>
import axios from 'axios';

export default {
    data() {
        return {
            tables: []
        }
    },
    mounted() {
        this.FetchTasks();
    },
    methods: {
        async FetchTasks() {
            const res = await axios.get('https://act-track.x10.mx/index.php/fetchalltask',{params:{ user_id: this.GetUserIDFromLocal()}});

            if(res.data.success) {
                this.tables = res.data.data;
            } else {
                this.error = 'Something went wrong during fetch';
                this.success = '';
                alert(this.error);
            }
        },
        GetUserIDFromLocal() {
            const user = JSON.parse(localStorage.getItem('user'));

            if(user && user.id) {
                return user.id;
            } else {
                this.error = "Failed to get user id";
                alert(this.error);
            }
        }
    }
}
</script>