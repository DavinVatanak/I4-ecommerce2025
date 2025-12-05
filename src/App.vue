<template>
  <div id="app">
    <div v-if="store.isLoading" class="loading">Loading...</div>
    <div v-if="store.errorMessage" class="error-message">
      {{ store.errorMessage }}
      <button @click="retryLoading" class="retry-button">Retry</button>
    </div>

    <template v-if="!store.isLoading && !store.errorMessage">
      <section class="groups">
        <GroupComponent />
      </section>

      <section class="categories">
        <CategoryComponent :groupName="'Group A'" />
      </section>

      <section class="promotions">
        <PromotionComponent
          v-for="promotion in store.promotions"
          :key="promotion.url"
          :title="promotion.title"
          :color="promotion.color"
          :image="promotion.image"
          :buttonColor="promotion.buttonColor"
          :url="promotion.url"
          :promotion="promotion"
        />
      </section>
    </template>
  </div>
</template>

<script lang="ts">
import { onMounted } from 'vue'
import { useProductStore } from './stores/products'
import CategoryComponent from './components/CategoryComponent.vue'
import PromotionComponent from './components/PromotionComponent.vue'
import GroupComponent from './components/GroupComponent.vue'

export default {
  name: 'App',
  components: {
    CategoryComponent,
    PromotionComponent,
    GroupComponent,
  },

  setup() {
    const store = useProductStore()

    const retryLoading = () => {
      store.errorMessage = ''
      store.fetchAllData()
    }

    onMounted(() => {
      store.fetchAllData()
    })

    return {
      store,
      retryLoading,
    }
  },

  methods: {
    async uploadImage(imageImport: string, fileName: string, fieldName = 'image') {
      try {
        // Convert imported image to File using store helper
        const file = await this.store.importImageAsFile(imageImport, fileName)

        // Upload the file
        const result = await this.store.postImage(file, fieldName)
        console.log('Image uploaded successfully:', result)
        return result
      } catch (error) {
        console.error('Failed to upload image:', error)
        throw error
      }
    },

    async uploadAnyImage(imagePath: string, fileName: string) {
      try {
        // Dynamic import for any image
        const imageImport = await import(imagePath)
        const result = await this.uploadImage(imageImport.default, fileName)
        console.log(`${fileName} uploaded:`, result)
        return result
      } catch (error) {
        console.error(`Failed to upload ${fileName}:`, error)
        throw error
      }
    },
  },
}
</script>

<style scoped>
.loading {
  padding: 20px;
  text-align: center;
  font-size: 1.2em;
  color: #666;
}

.error-message {
  padding: 20px;
  margin: 20px;
  background-color: #ffebee;
  border: 1px solid #ef9a9a;
  border-radius: 4px;
  color: #c62828;
  text-align: center;
}

.retry-button {
  margin-left: 15px;
  padding: 5px 15px;
  background-color: #1976d2;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 0.9em;
}

.retry-button:hover {
  background-color: #1565c0;
}

#app {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}

section {
  margin-bottom: 40px;
}

#app {
  margin: 20px auto 0;
  padding: 20px;
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  text-align: center;
  display: flex;
  flex-direction: column;
  background-color: white;
}

.categories,
.promotions {
  display: flex;
  gap: 16px;
  justify-content: center;
  margin-bottom: 24px;
}

section {
  margin-bottom: 40px;
}
</style>
