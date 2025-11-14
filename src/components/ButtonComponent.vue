<template>
  <button :class="['btn', variantClass]" @click="emit('click')">
    <span class="label">{{ text }}</span>
    <svg v-if="showArrow" class="arrow" viewBox="0 0 24 24" aria-hidden="true">
      <path
        d="M13 5l7 7-7 7M5 12h14"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
    </svg>
  </button>
</template>

<script setup lang="ts">
import { computed } from 'vue'
const emit = defineEmits(['click'])
const props = defineProps({
  text: {
    type: String,
    default: 'Click',
  },
  variant: {
    type: String,
    default: 'green',
  },
  showArrow: {
    type: Boolean,
    default: true,
  },
})

const variantClass = computed(() => {
  if (props.variant === 'yellow') return 'btn-yellow'
  return 'btn-green'
})
</script>

<style scoped>
.btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 18px;
  border-radius: 6px;
  border: none;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
}

.btn-green {
  background-color: #3bb77e;
  color: #fff;
}

.btn-yellow {
  background-color: #ffd480;
  color: #253d4e;
}

.label {
  line-height: 1;
}

.arrow {
  width: 18px;
  height: 18px;
  transition: transform 0.15s ease-in-out;
}

.btn:hover .arrow {
  transform: translateX(2px);
}
</style>
