<template>
    <div class="dropdown dropdown-bottom">
        <div tabindex="0" role="button" class="btn m-1 bg-[#ebe8e2] box mb-2">
            <p>All</p>
            <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                <path d="m480-340 180-180-57-56-123 123-123-123-57 56 180 180Zm0 260q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/>
            </svg>
        </div>
        <ul tabindex="0" class="dropdown-content menu rounded-box z-1 w-52 p-2 shadow-sm box bg-[#ebe8e2]">
            <li><a class="block p-2 rounded hover:!bg-blue-300 active:!bg-blue-300">Not Started</a></li>
            <li><a class="block p-2 rounded hover:!bg-gray-300 active:!bg-gray-300">In Progress</a></li>
            <li><a class="block p-2 rounded hover:!bg-yellow-300 active:!bg-yellow-300">Near Deadline</a></li>
            <li><a class="block p-2 rounded hover:!bg-green-300 active:!bg-green-300">Done</a></li>
            <li><a class="block p-2 rounded hover:!bg-orange-300 active:!bg-orange-300">Finished Late</a></li>
            <li><a class="block p-2 rounded hover:!bg-red-300 active:!bg-red-300">Missed</a></li>
        </ul>
    </div>
</template>