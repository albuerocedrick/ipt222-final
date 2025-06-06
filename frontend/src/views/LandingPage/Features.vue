<template>
    <div class="flex flex-col md:flex-row gap-4 text-center">
        <div
          :class="['box', 'h-75', 'bg-[#97DDCD]', 'md:w-1/3 w-full', 'flex', 'flex-col p-4 ', 'justify-center', 'gap-4', 'items-center']"
          v-for="(feature, index) in features"
          :key="index">
            <img
              class="w-20"
              :src="feature.imgpath"
              :alt="feature.alt">
            <h1 :class="['font-extrabold', 'md:text-4xl text-3xl text-black']">{{ feature.title }}</h1>
            <p :class="['font-semibold md:text-md text-sm']">{{ feature.desc }}</p>
        </div>
    </div>
</template>

<script>
import UsersIcon from '../../assets/UsersIcon.png'
import ClockIcon from '../../assets/ClockIcon.png'
import DashBoardIcon from '../../assets/DashBoardIcon.png'

export default {
    data() {
        return{
            features: [
                {  
                    title: 'Real-Time Collaboration', 
                    desc: 'Work with others and assign tasks instantly. Updates sync in real-time.',
                    alt: 'users icon',
                    imgpath: UsersIcon
                            
                },
                {
                    title: 'Deadline Reminders', 
                    desc: 'Get notified before your tasks are due.',
                    alt: 'clock icon',
                    imgpath: ClockIcon
                },
                {
                    title: 'Progress Dashboard', 
                    desc: 'See your task progress in one place.',
                    alt: 'dashboard icon',
                    imgpath:  DashBoardIcon
                },
            ]
        }
    }
}
</script>