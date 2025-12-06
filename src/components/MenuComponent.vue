<template>
  <div class="menu-container">
    <div class="menu-header">
      <h2 v-if="title" class="menu-title">{{ title }}</h2>
      <div class="menu-tabs">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          :class="['tab-button', { active: activeTab === tab.id }]"
          @click="selectTab(tab.id)"
        >
          {{ tab.label }}
        </button>
      </div>
    </div>
    <slot :active-tab="activeTab"></slot>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'

export interface MenuTab {
  id: string
  label: string
}

export default defineComponent({
  name: 'MenuComponent',

  props: {
    title: {
      type: String,
      default: '',
    },
    tabs: {
      type: Array as unknown as () => MenuTab[],
      required: true,
      validator: (value: unknown): value is MenuTab[] => {
        return (
          Array.isArray(value) &&
          value.every(
            (tab) =>
              tab &&
              typeof tab === 'object' &&
              'id' in tab &&
              'label' in tab &&
              typeof tab.id === 'string' &&
              typeof tab.label === 'string',
          )
        )
      },
    },
    initialTab: {
      type: String,
      default: '',
    },
  },

  emits: ['tab-change'],

  setup(props, { emit }) {
    const getInitialTab = () => {
      if (props.initialTab) return props.initialTab
      const tabs = props.tabs as MenuTab[]
      if (tabs && tabs.length > 0 && tabs[0]) {
        return tabs[0].id
      }
      return ''
    }

    const activeTab = ref(getInitialTab())

    const selectTab = (tabId: string) => {
      if (activeTab.value !== tabId) {
        activeTab.value = tabId
        emit('tab-change', tabId)
      }
    }

    return {
      activeTab,
      selectTab,
    }
  },
})
</script>

<style scoped>
.menu-container {
  margin-bottom: 2rem;
}

.menu-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
  flex-wrap: wrap;
  gap: 1rem;
}

.menu-title {
  font-size: 1.5rem;
  font-weight: 600;
  color: #253d4e;
  margin: 0;
}

.menu-tabs {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.tab-button {
  padding: 0.5rem 1.25rem;
  border-radius: 25px;
  border: none;
  background-color: transparent;
  color: #253d4e;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
  white-space: nowrap;
}

.tab-button:hover {
  background-color: #f2f3f4;
}

.tab-button.active {
  background-color: #3bb77e;
  color: white;
}

@media (max-width: 768px) {
  .menu-header {
    flex-direction: column;
    align-items: flex-start;
  }

  .menu-tabs {
    width: 100%;
    overflow-x: auto;
    padding-bottom: 0.5rem;
  }
}
</style>
