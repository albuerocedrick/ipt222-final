<template>
    <div class="p-4">
        <nav-bar class=""/>
        <div class="min-h-[87vh] bg-base-100 py-12 px-4 md:px-8 lg:px-16 box mt-4">
            <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-16">
                <h1 class="text-3xl md:text-5xl font-bold mb-6 text-primary">About Our Team</h1>
                <p class="text-lg md:text-xl max-w-3xl mx-auto">
                We're a passionate group dedicated to creating tools that simplify task management and enhance collaboration.
                </p>
            </div>

            <!-- Mission Section -->
            <div class="flex flex-col md:flex-row justify-center text-center items-center gap-12 mb-20">
                <div class="md:w-1/2">
                <h2 class="text-2xl md:text-4xl font-bold mb-6">Our Mission</h2>
                <p class="mb-4">
                    To empower individuals and teams to manage their tasks efficiently while fostering seamless collaboration.
                </p>
                <p>
                    We believe that the right tools should simplify your workflow, not complicate it. That's why we've built the ActTrack - to help you stay organized and connected with your team.
                </p>
                </div>
            </div>

            <!-- Team Members Section -->
            <div class="mb-20">
                <h2 class="text-2xl md:text-4xl font-bold mb-12 text-center">Meet The Team</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Team Member 1 -->
                <div v-for="(team, index) in teams" :key="index" class="card bg-base-200 shadow-xl hover:shadow-2xl transition-shadow">
                    <figure class="px-6 pt-6">
                    <img :src="team.src" alt="Team Member" class="rounded-xl w-full h-64 object-cover">
                    </figure>
                    <div class="card-body items-center text-center">
                    <h3 class="card-title text-xl">{{ team.name }}</h3>
                    <p class="text-primary">{{ team.role }}</p>
                    <p>{{team.desc}}</p>
                    </div>
                </div>

                

                </div>
            </div>

            <!-- Values Section -->
            <div class="bg-primary text-primary-content rounded-2xl p-8 md:p-12 mb-12">
                <h2 class="text-2xl md:text-4xl font-bold mb-8 text-center">Our Core Values</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="text-5xl mb-4">👥</div>
                    <h3 class="text-xl font-bold mb-2">Collaboration</h3>
                    <p>We believe great things happen when people work together effectively.</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl mb-4">💡</div>
                    <h3 class="text-xl font-bold mb-2">Innovation</h3>
                    <p>We're constantly seeking better ways to solve problems and improve workflows.</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl mb-4">🤝</div>
                    <h3 class="text-xl font-bold mb-2">Integrity</h3>
                    <p>We're committed to honesty, transparency, and building trust with our users.</p>
                </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="text-center mt-16">
                <h2 class="text-2xl md:text-4xl font-bold mb-6">Ready to Get Started?</h2>
                <button 
                class="btn btn-primary text-xl px-8 py-4 rounded-xl font-medium shadow-md hover:shadow-lg transition-all"
                @click="GoToSignUp"
                >
                Join Now
                </button>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
import NavBar from '../components/NavBar.vue'

export default {
    components: {
        NavBar
    },
    data() {
        return {
            teams: [
                {
                    name: "Banayo, Johnaeroll M.",
                    role: "Project Manager",
                    desc: "Leads the team by overseeing the project's progress, setting deadlines, managing tasks, and ensuring the team stays aligned with goals and client requirements.",
                    src: new URL('../assets/team-photo/aerol-banayo.png', import.meta.url).href
                },
                {
                    name: "Albuero, Cedrick A.",
                    role: "System Programmer",
                    desc: "Builds the core functionality of the system, writes clean and efficient code, and ensures the back-end logic runs smoothly and securely.",
                    src: new URL('../assets/team-photo/cedrick-albuero.png', import.meta.url).href
                },
                {
                    name: "Andaya, Arlee John Lenard T.",
                    role: "UI Designer",
                    desc: "Designs the look and feel of the system, creating user-friendly and visually appealing interfaces to enhance the user experience.",
                    src: new URL('../assets/team-photo/arlee-andaya.png', import.meta.url).href
                },
                {
                    name: "Felipe, Kathlene",
                    role: "Technical Writer 1",
                    desc: "Writes clear documentation such as system manuals, reports, and user guides, ensuring the technical aspects are well explained and organized.",
                    src: new URL('../assets/team-photo/kathlene-felipe.png', import.meta.url).href
                },
                {
                    name: "Azores, Kyle C.",
                    role: "Technical Writer 2",
                    desc: "Supports the documentation process by proofreading, formatting, and creating diagrams or flowcharts to help users and developers understand the system.",
                    src: new URL('../assets/team-photo/kyle-azores.png', import.meta.url).href
                },
                {
                    name: "Magadia, AJ",
                    role: "Test Framer 1",
                    desc: "Develops test cases and testing strategies to check if the system works as intended, helping to identify bugs early.",
                    src: new URL('../assets/team-photo/aj-magadia.png', import.meta.url).href
                },
                {
                    name: "Bautista, John Justin M.",
                    role: "Test Framer 2",
                    desc: "Executes test cases and records results, working closely with the team to verify that fixes are effective and the system meets quality standards.",
                    src: new URL('../assets/team-photo/justin-bautista.png', import.meta.url).href
                },
            ]
        }
    },
  methods: {
    GoToSignUp() {
      this.$router.push('/signup')
    }
  }
}
</script>

<style scoped>
.hover-effect:hover {
  transform: translateY(-2px);
  transition: transform 0.2s ease;
}
</style>