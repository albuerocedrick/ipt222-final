<template>
    <div>
        <button class="btn rounded-2xl box bg-[#97ddcd] font-medium mb-2" onclick="my_modal_3.showModal()">
            <p class="font-bold text-xl pb-1">+</p>
            <p>New Project</p>
        </button>

        <dialog ref="myModal" id="my_modal_3" class="modal">
            <div class="modal-box box bg-[#ebe8e2]">
                <form method="dialog" @submit.prevent="CreateProject">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" @click.prevent="CloseModal">✕</button>

                    <div class="w-full font-medium flex flex-col items-center mt-4">
                            <div class="w-full flex flex-col mb-2">
                                <label for="name" class="mr-2">Name:<br></label>
                                <input v-model="form.name" id="name" type="text" class="input rounded-2xl focus:outline-0 w-full h-12 font-medium" />
                            </div>
                            <div class="w-full flex flex-col">
                                <label for="desc" class="mr-2">Description:<br></label>
                                <textarea v-model="form.description" id="desc" type="text" rows="4" class="input rounded-2xl focus:outline-0 w-full h-38 p-2 font-medium" />
                            </div>
                    </div>
                    <button type="submit" class="btn bg-[#50b9a1] rounded-2xl mt-4 border-gray-400" @click="$refs.myModal.close()">Add Project</button>
                </form>
                
            </div>
        </dialog>
    </div>
</template>

<script>
import axios from 'axios';


export default {
    props: [],
    data() {
        return {
            form: {
                id: '',
                name: '',
                description: '',
            },
            error: '',
            success: ''
        }
    },
    methods: {
        async CreateProject() {
            const userCred = JSON.parse(localStorage.getItem('user'));
            this.form.id = userCred.id;

            const res = await axios.post('http://localhost/IPT_FINAL_PROJ/backend/index.php/add', this.form);

            if(res.data.success) {
                this.success = res.data.message;
                this.error = '';
                alert(this.success);
                
                this.$bus.$emit("refresh-projects");

                this.CloseModal();
            } else {
                this.success = '';
                this.error = 'Something went wrong';
                alert(this.error);
            }
        },
        ResetForm() {
            this.form.id  = '';
            this.form.name  = '';
            this.form.description  = '';
        },
        CloseModal() {
            this.$refs.myModal.close();
            this.ResetForm();
        }
    }
}
</script>