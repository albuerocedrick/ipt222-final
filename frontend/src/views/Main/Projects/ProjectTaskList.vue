<template>
    <div class="h-full bg-base-100 flex flex-col overflow-hidden box pb-6">
        <!-- Fixed Header -->
        <div class="flex flex-row justify-between border-b border-neutral/30 rounded-t-2xl h-20 items-center px-6 flex-shrink-0"> 
            <div class="flex flex-row items-center text-center h-16 justify-between w-full">
                <h1 class="font-bold text-2xl">Projects</h1>
                <button class="p-2 btn btn-secondary rounded-2xl text-secondary-content hover-effect">
                    <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960" fill="currentColor">
                        <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/>
                    </svg>
                </button>
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
            activeProjectID: null,
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
        
    },
    watch: {
        activeProjectID(newVal) {
            if (newVal !== null) {
            const openedFolder = this.folders.find(f => f.project_id === newVal);
            this.$bus.$emit("FetchTasksByProj", openedFolder.project_id);
            }
        }
    },
}
</script>