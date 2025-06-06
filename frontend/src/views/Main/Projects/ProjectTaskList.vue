<template>
    <div class="h-full bg-[#ebe8e2] flex flex-col overflow-hidden box">
        <!-- Fixed Header -->
        <div class="flex flex-row justify-between bg-[#62d5ba] rounded-t-2xl h-20 items-center px-4 flex-shrink-0"> 
            <p class="font-semibold text-2xl">Tasks</p>
        </div>

        <!-- Scrollable Content Area -->
        <div class="flex-1 overflow-y-auto px-2 py-2">
            <div class="collapse bg-base-100 box mb-2 w-full relative" v-for="folder in folders" :key="folder.project_id">
                <input type="radio" name="my-accordion-2" checked="checked" />
                
                <div class="collapse-title font-semibold flex flex-row items-center justify-between">
                    <div class="flex flex-row items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                        <p class="pl-2">{{ folder.project_name }}</p>
                    </div>

                    <dialog :ref="'dialog_' + folder.project_id" class="modal">
                        <div class="modal-box">
                            <form method="dialog">
                                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                            </form>
                            <h3 class="text-lg font-bold">Members:</h3>
                            <p class="py-4 pl-4 font-semibold">Owner:</p>
                            <p class="py-2 pl-4 font-semibold">Collaborators:</p>
                        </div>
                    </dialog>
                </div>

                <button @click="openDialog(folder.project_id)" class="absolute z-10 top-4 right-4">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#6B7280">
                            <path d="M240-400q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm240 0q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm240 0q-33 0-56.5-23.5T640-480q0-33 23.5-56.5T720-560q33 0 56.5 23.5T800-480q0 33-23.5 56.5T720-400Z"/>
                        </svg>
                </button>

                <div class="collapse-content text-sm overflow-visible relative z-10">
                    <div class="mb-2 flex flex-row justify-between"> 
                        <p><b>Project ID:</b> {{ folder.project_id }}-{{ folder.owner_id }}</p>

                        
                    </div>

                    <p><b>Description:</b> {{ folder.description }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            userId: '',
            folders: [],
            error: '',
            success: '',
            openDropdown: null,
        }
    },
    mounted() {
        this.ProjectInfo();
        this.$bus.$on("refresh-projects", this.ProjectInfo);
    },
    beforeUnmount() {
        this.$bus.$off("refresh-projects", this.ProjectInfo)
    },
    methods: {
        async ProjectInfo() {  
            const res = await axios.get('http://localhost/IPT_FINAL_PROJ/backend/index.php/fetch',{params: { user_id: this.GetUserIDFromLocal() }});

            if(res.data.success) {
                this.folders = res.data.data;
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
        },
        openDialog(projectId) {
            const dialog = this.$refs['dialog_' + projectId];
            
            // If using Vue 3 with <script setup> or Composition API, use .value
            if (Array.isArray(dialog)) {
                dialog[0].showModal(); // In case ref returns array due to v-for
            } else if (dialog && dialog.showModal) {
                dialog.showModal();
            }
        },
    }
}
</script>