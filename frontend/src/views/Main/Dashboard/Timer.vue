<template>
  <div class="box bg-base-100 rounded-xl p-6 h-full flex flex-col">
    <!-- Timer Header -->
    <div class="flex items-center justify-between mb-3">
      <div class="timer-mode text-xs text-base-content/70 uppercase tracking-wide font-semibold">
        {{ currentMode }}
      </div>
      <div class="timer-display text-xl font-mono font-bold text-base-content">
        {{ formattedTime }}
      </div>
    </div>

    <!-- Linear Progress Bar -->
    <div class="mb-3 flex-shrink-0">
      <div class="w-full bg-base-300 rounded-full h-2 overflow-hidden">
        <div 
          class="h-full rounded-full transition-all duration-1000 ease-in-out"
          :style="{ 
            width: progressPercentage + '%', 
            backgroundColor: progressColor 
          }"
        ></div>
      </div>
    </div>

    <!-- Main Control Button -->
    <div class="flex-1 flex items-center justify-center">
      <button
        @click="toggleTimer"
        class="btn btn-sm px-4"
        :class="isRunning ? 'btn-error' : 'btn-primary'"
      >
        <svg v-if="!isRunning" class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
          <path d="M8 5v14l11-7z"/>
        </svg>
        <svg v-else class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
          <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
        </svg>
        {{ isRunning ? 'Pause' : 'Start' }}
      </button>
    </div>

    <!-- Timer Controls -->
    <div class="mt-auto space-y-2">
      <!-- Mode Selection -->
      <div class="flex gap-1 justify-center">
        <button
          v-for="mode in timerModes"
          :key="mode.name"
          @click="setMode(mode)"
          class="btn btn-xs text-xs px-2"
          :class="currentMode === mode.name ? 'btn-primary' : 'btn-ghost'"
        >
          {{ mode.name.split(' ')[0] }}
        </button>
      </div>

      <!-- Time Adjustment & Reset -->
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-1">
          <button
            @click="adjustTime(-1)"
            :disabled="isRunning"
            class="btn btn-xs btn-ghost"
          >
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
            </svg>
          </button>
          
          <span class="text-xs text-base-content/70 min-w-0 text-center px-1">
            {{ Math.floor(totalSeconds / 60) }}m
          </span>
          
          <button
            @click="adjustTime(1)"
            :disabled="isRunning"
            class="btn btn-xs btn-ghost"
          >
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
          </button>
        </div>

        <button
          @click="resetTimer"
          class="btn btn-xs btn-ghost text-xs"
        >
          Reset
        </button>
      </div>
    </div>

    <!-- Completion Alert -->
    <div
      v-if="isCompleted"
      class="alert alert-success mt-2 p-2"
    >
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      <span class="text-xs">Timer completed! 🎉</span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TaskTimer',
  data() {
    return {
      totalSeconds: 25 * 60, // Default 25 minutes (Pomodoro)
      remainingSeconds: 25 * 60,
      isRunning: false,
      isCompleted: false,
      interval: null,
      currentMode: 'Focus',
      timerModes: [
        { name: 'Focus', duration: 25 * 60, color: 'oklch(var(--color-primary))' },
        { name: 'Short Break', duration: 5 * 60, color: 'oklch(var(--color-success))' },
        { name: 'Long Break', duration: 15 * 60, color: 'oklch(var(--color-secondary))' },
        { name: 'Custom', duration: 30 * 60, color: 'oklch(var(--color-accent))' }
      ]
    }
  },
  computed: {
    formattedTime() {
      const minutes = Math.floor(this.remainingSeconds / 60)
      const seconds = this.remainingSeconds % 60
      return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`
    },
    progressPercentage() {
      return ((this.totalSeconds - this.remainingSeconds) / this.totalSeconds) * 100
    },
    progressColor() {
      const mode = this.timerModes.find(m => m.name === this.currentMode)
      return mode ? mode.color : 'oklch(var(--color-primary))'
    }
  },
  methods: {
    toggleTimer() {
      if (this.isCompleted) {
        this.resetTimer()
        return
      }
      
      this.isRunning = !this.isRunning
      
      if (this.isRunning) {
        this.startTimer()
      } else {
        this.pauseTimer()
      }
    },
    startTimer() {
      this.interval = setInterval(() => {
        if (this.remainingSeconds > 0) {
          this.remainingSeconds--
        } else {
          this.completeTimer()
        }
      }, 1000)
    },
    pauseTimer() {
      if (this.interval) {
        clearInterval(this.interval)
        this.interval = null
      }
    },
    completeTimer() {
      this.isRunning = false
      this.isCompleted = true
      this.pauseTimer()
      
      // Play notification sound (if browser supports it)
      this.playNotificationSound()
      
      // Emit completion event
      this.$emit('timer-completed', {
        mode: this.currentMode,
        duration: this.totalSeconds
      })
    },
    resetTimer() {
      this.pauseTimer()
      this.isRunning = false
      this.isCompleted = false
      this.remainingSeconds = this.totalSeconds
    },
    setMode(mode) {
      if (this.isRunning) return
      
      this.currentMode = mode.name
      this.totalSeconds = mode.duration
      this.remainingSeconds = mode.duration
      this.isCompleted = false
    },
    adjustTime(minutes) {
      if (this.isRunning) return
      
      const newTime = this.totalSeconds + (minutes * 60)
      if (newTime >= 60) { // Minimum 1 minute
        this.totalSeconds = newTime
        this.remainingSeconds = newTime
        this.isCompleted = false
      }
    },
    playNotificationSound() {
      // Create a simple beep sound using Web Audio API
      try {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)()
        const oscillator = audioContext.createOscillator()
        const gainNode = audioContext.createGain()
        
        oscillator.connect(gainNode)
        gainNode.connect(audioContext.destination)
        
        oscillator.frequency.value = 800
        oscillator.type = 'sine'
        
        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime)
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5)
        
        oscillator.start(audioContext.currentTime)
        oscillator.stop(audioContext.currentTime + 0.5)
      } catch (error) {
        console.log('Audio notification not supported')
      }
    }
  },
  beforeUnmount() {
    this.pauseTimer()
  }
}
</script>

<style scoped>
.timer-container {
  border-left: 4px solid oklch(var(--color-primary));
}

.timer-display {
  font-variant-numeric: tabular-nums;
}

.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: .5;
  }
}
</style>