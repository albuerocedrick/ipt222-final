<template>
    <div class="flex flex-col h-full box bg-[#ebe8e2] overflow-y-auto">
        <div class="flex flex-row justify-between mb-4 bg-[#62d5ba] rounded-t-2xl h-20 items-center px-4"> 
            <p :class="['font-semibold text-2xl']">Tasks</p>
        </div>
        <div class="h-32 rounded-2xl border border-gray-400 p-4 hover:bg-[#a2cffe]/30 mx-4 shadow-sm mb-2">
            <p class="font-medium text-2xl whitespace-nowrap overflow-hidden text-ellipsis">Assignment QUAMETH</p>
            <p class="text-black/60 mb-2">Due Date: May 30, 2025</p>
            <div class="badge badge-outline !border-yellow-500 text-yellow-500">
                Near Deadline
            </div>
        </div>
        <div class="h-32 rounded-2xl border border-gray-400 p-4 hover:bg-[#a2cffe]/30 mx-4 shadow-sm mb-2">
            <p class="font-medium text-2xl whitespace-nowrap overflow-hidden text-ellipsis">Assignment QUAMETH</p>
            <p class="text-black/60 mb-2">Due Date: June 1, 2025</p>
            <div class="badge badge-outline !border-green-500 text-green-500">
                Done
            </div>
        </div>
        <div class="h-32 rounded-2xl border border-gray-400 p-4 hover:bg-[#a2cffe]/30 mx-4 shadow-sm mb-2">
            <p class="font-medium text-2xl whitespace-nowrap overflow-hidden text-ellipsis">Assignment QUAMETH</p>
            <p class="text-black/60 mb-2">Due Date: June 2, 2025</p>
            <div class="badge badge-outline !border-gray-500 text-gray-500">
                In Progress
            </div>
        </div>
        <div class="h-32 rounded-2xl border border-gray-400 p-4 hover:bg-[#a2cffe]/30 mx-4 shadow-sm mb-2">
            <p class="font-medium text-2xl whitespace-nowrap overflow-hidden text-ellipsis">Assignment QUAMETH</p>
            <p class="text-black/60 mb-2">Due Date: June 2, 2025</p>
            <div class="badge badge-outline !border-blue-500 text-blue-500">
                Not Started
            </div>
        </div>
    </div>
</template>