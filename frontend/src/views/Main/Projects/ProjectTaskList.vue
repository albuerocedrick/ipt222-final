<template>
    <div class="box bg-[#ebe8e2] flex flex-col items-center ">
        <div class="flex flex-row justify-between mb-4 bg-[#62d5ba] rounded-t-2xl h-20 items-center px-4 w-full"> 
            <p :class="['font-semibold text-2xl']">Tasks</p>
        </div>

        <div class="collapse bg-base-100 box mb-2 mx-2 w-11/12 overflow-visible relative" v-for="folder in folders" :key="folder.project_id">
            <input type="radio" name="my-accordion-2" checked="checked" />
            
            <div class="collapse-title font-semibold flex flex-row items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
                <p class="pl-2">{{ folder.project_name }}</p>
            </div>

            <div class="collapse-content text-sm overflow-visible relative z-10">
                <div class="mb-2 flex flex-row justify-between"> 
                    <p><b>Project ID:</b> {{ folder.project_id }}-{{ folder.owner_id }}</p>

                        <button @click="openDialog(folder.project_id)">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                <path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/>
                            </svg>
                        </button>

                        <dialog :ref="'dialog_' + folder.project_id" class="modal">
                            <div class="modal-box">
                                <form method="dialog">
                                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                </form>
                                <h3 class="text-lg font-bold">Members:</h3>
                                <p class="py-4 pl-4 font-semibold">Admin:</p>
                                <p class="py-2 pl-4 font-semibold">Collaborators:</p>
                            </div>
                        </dialog>
                </div>

                <p><b>Description:</b> {{ folder.description }}</p>
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
        }
    },
    mounted() {
        this.ProjectInfo();
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
        }
    }
}
</script>