<template>
    <div>
        <button class="btn rounded-2xl box bg-[#97ddcd] font-medium mb-2" onclick="my_modal.showModal()">
            <p class="font-bold text-xl pb-1">+</p>
            <p>Join Project</p>
        </button>

        <dialog ref="myModal" id="my_modal" class="modal">
            <div class="modal-box box bg-[#ebe8e2]">
                <form method="dialog" @submit.prevent="CreateProject">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" @click.prevent="CloseModal">✕</button>

                    <div class="w-full font-medium flex flex-col items-center mt-4">
                            <div class="w-full flex flex-col mb-2">
                                <label for="id" class="mr-2 mb-4">Enter Project ID:<br></label>
                                <input v-model="id" id="id" type="text" placeholder="1111-1111" class="input rounded-2xl focus:outline-0 w-full h-12 font-medium" />
                            </div>
                    </div>
                    <button type="submit" class="btn bg-[#50b9a1] rounded-2xl mt-2 border-gray-400" @click="$refs.myModal.close()">Join</button>
                </form>
                
            </div>
        </dialog>
    </div>
</template>

<script>
export default {
    data() {
        return {
            id: '',
        }
    },
    methods: {
        ResetForm() {
            this.id  = '';
        },
        CloseModal() {
            this.$refs.myModal.close();
            this.ResetForm();
        },
    }
}
</script>