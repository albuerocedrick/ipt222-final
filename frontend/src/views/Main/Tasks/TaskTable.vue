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
                <tr>
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
                    <td>{{ table.project }}</td>
                    <td>{{ table.startDate }}</td>
                    <td>{{ table.endDate }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

export default {
    data() {
        return {
            table: {
                title: '',
                status: '',
                project: '',
                startDate: '',
                endDate: '',
            }
        }
    }
}
</script>