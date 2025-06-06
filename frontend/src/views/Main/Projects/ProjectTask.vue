<template>
    <div class="flex flex-col h-full box bg-[#ebe8e2] overflow-y-auto">
        <div class="flex flex-row justify-between mb-4 bg-[#62d5ba] rounded-t-2xl h-20 items-center px-4"> 
            <p :class="['font-semibold text-2xl']">Tasks</p>
        </div>
        <div class="h-20 rounded-2xl border border-gray-400 p-4 mx-4 shadow-sm mb-2 flex flex-row justify-between items-center bg-base-100">
                <p class="font-medium text-xl whitespace-nowrap overflow-hidden text-ellipsis ">Assignment QUAMETH</p>
            <div class="badge badge-outline !border-yellow-500 text-yellow-500">
                Near Deadline
            </div>
        </div>
    </div>
</template>