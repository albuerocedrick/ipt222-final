<template>
    <div class="flex flex-row h-full box bg-base-100 ">
        <div class="h-full w-2/5 border-r border-neutral/30 flex flex-col ">
            <div class="w-full h-2/5 border-b border-neutral/30 p-6">
                <div class="flex flex-row justify-between items-start">
                    <h1 class="font-bold text-2xl pb-6">IPT222 - ActTrack</h1>
                    <div class="flex flex-row gap-2">
                        <span class="p-2 bg-warning rounded-2xl text-secondary-content hover-effect">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" fill="currentColor"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                        </span>
                        <span class="p-2 bg-error rounded-2xl text-error-content hover-effect">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" fill="currentColor"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                        </span>
                    </div>
                </div>
                <p>Review the client feedback on the draft proposal and make the necessary adjustments to the layout, color scheme, and typography. Prepare the updated Figma prototype and export PDF versions for the meeting. Ensure all links and navigation elements work as expected in the prototype.</p>
            </div>
            <div class="w-full h-3/5 p-6  px-6 pb-6 pt-2">
                <div class="flex flex-row items-center text-center h-16 justify-between">
                    <div>
                        <h1 class="font-bold text-xl ">Members</h1>
                    </div>
                    <span class="p-2 bg-secondary rounded-2xl text-secondary-content hover-effect">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" fill="currentColor">
                            <path d="M720-400v-120H600v-80h120v-120h80v120h120v80H800v120h-80Zm-360-80q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm80-80h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0-80Zm0 400Z"/></svg>
                    </span>
                </div>
            </div>
        </div>
        <div class="h-full w-3/5 px-6 pb-6 pt-4">
            <div class="flex flex-row items-center text-center h-16 justify-between">
                <div>
                    <h1 class="font-bold text-2xl ">Tasks</h1>
                </div>
                <span class="p-2 bg-secondary rounded-2xl text-secondary-content hover-effect">
                    <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960" fill="currentColor">
                        <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/>
                    </svg>
                </span>
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