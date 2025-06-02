<template>
    <div class="row-span-2 box bg-[#EBE8E2]">
        <div class="flex flex-row justify-between mb-4 bg-[#a2cffe] rounded-t-2xl h-16 bg-[] items-center px-4"> 
            <p :class="['font-semibold text-xl']">Projects</p>
        </div>
        <div class="flex flex-row items-center gap-4 rounded-2xl h-16 px-2 mb-2 mx-4 mt-4  shadow-sm border border-gray-400 hover:bg-[#a2cffe]/30">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
            </svg>
            <p class="font-medium whitespace-nowrap overflow-hidden text-ellipsis">
                QUAMETH
            </p>
        </div>
    </div>
</template>