<template>
    <div class="overflow-y-auto">
        <dialog id="my_modal_4" class="modal">
            <div class="modal-box box w-full max-w-4xl h-full max-h-[70%]">
                <div class="border-b border-neutral/30 h-1/15">
                    <h1 class="font-bold text-xl mb-4">Task Details</h1>
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2 ">✕</button>
                    </form>
                </div>    
                <form class="flex flex-row items-center h-14/15">
                    <div class="w-1/2 h-full border-r border-neutral/30 flex flex-col">
                        <div class="h-1/2 border-b border-neutral/30 py-4 pr-4">
                            <h1 class="font-bold text-2xl pt-2 pb-4">Create A Dashboard for IPT</h1>
                            <p>Create a dashboard for IPT. Add some analytics and other stuffs</p>
                        </div>
                        <div class="h-1/2 flex flex-col gap-4 pr-4">
                            <h1 class="font-bold text-xl mt-6">Details</h1>
                            <div class="flex flex-row justify-between items-center text-center">
                                <span class="flex flex-row gap-2 items-center text-neutral/80 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" fill="currentColor"><path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Z"/></svg>
                                    <p>Start Date</p>
                                </span>
                                <p class="pr-2 font-medium">October 17, 2025</p>
                            </div>
                            <div class="flex flex-row justify-between items-center text-center">
                                <span class="flex flex-row gap-2 items-center text-neutral/80 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" fill="currentColor"><path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Z"/></svg>
                                    <p>Deadline</p>
                                </span>
                                <p class="pr-2 font-medium">October 17, 2025</p>
                            </div>
                            <div class="flex flex-row justify-between items-center text-center">
                                <span class="flex flex-row items-center gap-2 text-neutral/80 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" fill="currentColor" class="inline-block">
                                        <path d="M480-120q-33 0-56.5-23.5T400-200q0-33 23.5-56.5T480-280q33 0 56.5 23.5T560-200q0 33-23.5 56.5T480-120Zm-80-240v-480h160v480H400Z"/>
                                    </svg>
                                    <p class="text-base">Status</p>
                                </span>
                                <div class="badge badge-soft !text-gray-500">
                                    Not Started
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Right section -->
                    <div class="w-1/2 h-full pl-4 flex flex-col">
                        <h1 class="font-bold text-xl mt-4 mb-2">Attach Image for Proof</h1>
                        <div class="flex-1 flex flex-col gap-4">
                        <!-- Drop Zone -->
                        <div
                            id="dropzone"
                            class="border-2 border-dashed border-neutral/30 rounded-lg p-6 text-center hover:border-primary/50 transition-colors cursor-pointer bg-base-200/50"
                            @click="triggerFileUpload"
                            @dragover.prevent="onDragOver"
                            @dragleave.prevent="onDragLeave"
                            @drop.prevent="onDrop"
                            :class="{'border-primary bg-primary/10': isDragging}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-neutral/60 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="text-sm text-neutral/80 mb-2">Drag and drop images here, or click to browse</p>
                            <p class="text-xs text-neutral/60">PNG, JPG, GIF up to 10MB</p>
                            <input type="file" ref="fileInput" class="hidden" accept="image/*" multiple @change="onFileChange">
                        </div>

                        <!-- Image Preview Section -->
                        <div class="flex-1 overflow-y-auto max-h-64">
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <div
                                v-for="(img, index) in images"
                                :key="index"
                                class="relative"
                                >
                                <!-- Image Box -->
                                <div class="aspect-square rounded-lg overflow-hidden bg-base-200 relative">
                                    <img
                                    :src="img.src"
                                    :alt="img.name"
                                    class="w-full h-full object-cover"
                                    />

                                    <!-- Always-visible Remove Button -->
                                    <button
                                    type="button"
                                    class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center shadow hover:bg-red-600 transition"
                                    @click="removeImage(index)"
                                    >
                                    ✕
                                    </button>
                                </div>

                                <!-- Image Name -->
                                <p class="text-xs text-center mt-1 truncate px-1" :title="img.name">
                                    {{ img.name }}
                                </p>
                                </div>
                            </div>
                        </div>

                        <!-- Add Image Button -->
                        <button type="button" class="btn btn-outline btn-primary w-full">
                            Submit Task
                        </button>
                        </div>
                    </div>
                </form>
            </div>
        </dialog>
        <div class="overflow-x-auto bg-base-100 mt-4 box mb-8">
            <table class="table">
                <!-- head -->
                <thead>
                <tr class="h-20 text-base-content">
                    <th class="w-1/2 text-2xl pl-6 text-error">Today</th>
                    <th class="1/6">Deadline</th>
                    <th class="1/6">Status</th>
                    <th class="1/6">Project</th>
                </tr>
                </thead>
                <tbody>
                <!-- row 1 -->
                <tr class="h-16 cursor-pointer hover:bg-neutral/10" onclick="my_modal_4.showModal()">
                    <th class="pl-6">Create a Dashboard for IPT</th>
                    <td class="font-medium">Today</td>
                    <td class="font-medium">
                        <div class="badge badge-soft !text-yellow-500">
                                Near Deadline
                        </div>
                    </td>
                    <td class="font-medium">IPT222 - ActTrack</td>

                </tr>
                <!-- row 1 -->
                <tr class="h-16">
                    <th class="pl-6">Create a Dashboard for IPT</th>
                    <td class="font-medium">Today</td>
                    <td class="font-medium">
                        <div class="badge badge-soft !text-yellow-500">
                                Near Deadline
                        </div>
                    </td>
                    <td class="font-medium">IPT222 - ActTrack</td>
                </tr>
                <!-- row 1 -->
                <tr class="h-16">
                    <th class="pl-6">Create a Dashboard for IPT</th>
                    <td class="font-medium">Today</td>
                    <td class="font-medium">
                        <div class="badge badge-soft !text-yellow-500">
                                Near Deadline
                        </div>
                    </td>
                    <td class="font-medium">IPT222 - ActTrack</td>
                </tr>
                <!-- row 1 -->
                <tr class="h-16">
                    <th class="pl-6">Create a Dashboard for IPT</th>
                    <td class="font-medium">Today</td>
                    <td class="font-medium">
                        <div class="badge badge-soft !text-yellow-500">
                                Near Deadline
                        </div>
                    </td>
                    <td class="font-medium">IPT222 - ActTrack</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="overflow-x-auto bg-base-100 mt-4 box mb-8">
            <table class="table">
                <!-- head -->
                <thead>
                <tr class="h-20 text-base-content">
                    <th class="w-1/2 text-2xl pl-6 text-warning">Tomorrow</th>
                    <th class="1/6">Deadline</th>
                    <th class="1/6">Status</th>
                    <th class="1/6">Project</th>
                </tr>
                </thead>
                <tbody>
                <!-- row 1 -->
                <tr class="h-16">
                    <th class="pl-6">Create a Dashboard for IPT</th>
                    <td class="font-medium">Tomorrow</td>
                    <td class="font-medium">
                        <div class="badge badge-soft !text-blue-500">
                                In Progress
                        </div>
                    </td>
                    <td class="font-medium">IPT222 - ActTrack</td>
                </tr>
                <!-- row 1 -->
                <tr class="h-16">
                    <th class="pl-6">Create a Dashboard for IPT</th>
                    <td class="font-medium">Tomorrow</td>
                    <td class="font-medium">
                        <div class="badge badge-soft !text-blue-500">
                                In Progress
                        </div>
                    </td>
                    <td class="font-medium">IPT222 - ActTrack</td>
                </tr>
                <!-- row 1 -->
                <tr class="h-16">
                    <th class="pl-6">Create a Dashboard for IPT</th>
                    <td class="font-medium">Tomorrow</td>
                    <td class="font-medium">
                        <div class="badge badge-soft !text-blue-500">
                                In Progress
                        </div>
                    </td>
                    <td class="font-medium">IPT222 - ActTrack</td>
                </tr>
                <!-- row 1 -->
                <tr class="h-16">
                    <th class="pl-6">Create a Dashboard for IPT</th>
                    <td class="font-medium">Tomorrow</td>
                    <td class="font-medium">
                        <div class="badge badge-soft !text-blue-500">
                                In Progress
                        </div>
                    </td>
                    <td class="font-medium">IPT222 - ActTrack</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="overflow-x-auto bg-base-100 mt-4 box">
            <table class="table">
                <!-- head -->
                <thead>
                <tr class="h-20 text-base-content">
                    <th class="w-1/2 text-2xl pl-6 text-success ">Others</th>
                    <th class="1/6">Deadline</th>
                    <th class="1/6">Status</th>
                    <th class="1/6">Project</th>
                </tr>
                </thead>
                <tbody>
                <!-- row 1 -->
                <tr class="h-16">
                    <th class="pl-6">Create a Dashboard for IPT</th>
                    <td class="font-medium">Tomorrow</td>
                    <td class="font-medium">
                        <div class="badge badge-soft !text-gray-500">
                            Not Started
                        </div>
                    </td>
                    <td class="font-medium">IPT222 - ActTrack</td>
                </tr>
                <!-- row 1 -->
                <tr class="h-16">
                    <th class="pl-6">Create a Dashboard for IPT</th>
                    <td class="font-medium">Tomorrow</td>
                    <td class="font-medium">
                        <div class="badge badge-soft !text-blue-500">
                                In Progress
                        </div>
                    </td>
                    <td class="font-medium">IPT222 - ActTrack</td>
                </tr>
                <!-- row 1 -->
                <tr class="h-16">
                    <th class="pl-6">Create a Dashboard for IPT</th>
                    <td class="font-medium">Tomorrow</td>
                    <td class="font-medium">
                        <div class="badge badge-soft !text-gray-500">
                                Not Started
                        </div>
                    </td>
                    <td class="font-medium">IPT222 - ActTrack</td>
                </tr>
                <!-- row 1 -->
                <tr class="h-16">
                    <th class="pl-6">Create a Dashboard for IPT</th>
                    <td class="font-medium">Tomorrow</td>
                    <td class="font-medium">
                        <div class="badge badge-soft !text-blue-500">
                                In Progress
                        </div>
                    </td>
                    <td class="font-medium">IPT222 - ActTrack</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    
</template>

<script>
export default {
  name: "TaskDetailsModal",
  data() {
    return {
      showModal: false,
      isDragging: false,
      images: [],
    };
  },
  methods: {
    triggerFileUpload() {
      this.$refs.fileInput.click();
    },
    onFileChange(e) {
      const files = Array.from(e.target.files);
      this.handleFiles(files);
    },
    onDragOver() {
      this.isDragging = true;
    },
    onDragLeave() {
      this.isDragging = false;
    },
    onDrop(e) {
      this.isDragging = false;
      const files = Array.from(e.dataTransfer.files);
      this.handleFiles(files);
    },
    handleFiles(files) {
      files.forEach((file) => {
        if (file.type.startsWith("image/")) {
          const reader = new FileReader();
          reader.onload = (e) => {
            this.images.push({ src: e.target.result, name: file.name });
          };
          reader.readAsDataURL(file);
        }
      });
    },
    removeImage(index) {
      this.images.splice(index, 1);
    },
  },
};
</script>