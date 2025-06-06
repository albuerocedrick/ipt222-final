<template>
    <div class="overflow-x-auto rounded-box border border-base-content/5 bg-[#ebe8e2] box">
        <table class="table">
            <!-- head -->
            <thead>
                <tr class="text-black">
                    <th>Title</th>
                    <th>Status</th>
                    <th>Project</th>
                    <th>Start Date</th>
                    <th>Deadline</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                <tr v-for="table in tables" :key="table.task_id">
                    <td>{{ table.title }}</td>
                    <td>
                        <div :class="['badge badge-outline border-2', 
                                    {'!border-yellow-500 text-yellow-500': table.status == 'Near Deadline'},
                                    {'!border-blue-500 text-blue-500': table.status == 'Not Started'},
                                    {'!border-gray-500 text-gray-500': table.status == 'In Progress'},
                                    {'!border-orange-500 text-orange-500': table.status == 'Finished Late'},
                                    {'!border-green-500 text-green-500': table.status == 'Done'},
                                    {'!border-red-500 text-red-500': table.status == 'Missed'},
                                    ]">
                            {{ table.status }}
                        </div>
                    </td>
                    <td>{{ table.project_name }}</td>
                    <td>{{ table.start_date }}</td>
                    <td>{{ table.due_date }}</td>
                </tr>
            </tbody>
        </table>
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
            const res = await axios.get('http://localhost/IPT_FINAL_PROJ/backend/index.php/fetchtask',{params:{ user_id: this.GetUserIDFromLocal()}});

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