<template>
  <div id="app">
    <div v-if="store.isLoading" class="loading">Loading...</div>
    <div v-else-if="store.errorMessage" class="error-message">
      {{ store.errorMessage }}
      <button @click="retryLoading" class="retry-button">Retry</button>
    </div>

    <template v-else>
      <!-- Featured Categories Section -->
      <section class="featured-section">
        <MenuComponent
          title="Featured Categories"
          :tabs="categoryTabs"
          :initialTab="activeCategoryTab"
          @tab-change="handleCategoryTabChange"
        >
          <template #default="{ activeTab: activeCategoryTab }">
            <CategoryComponent
              :key="activeCategoryTab"
              :groupName="activeCategoryTab === 'all' ? undefined : activeCategoryTab"
            />
          </template>
        </MenuComponent>
      </section>

      <!-- Promotions Section -->
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

      <!-- Popular Products Section -->
      <section class="popular-products">
        <MenuComponent
          title="Popular Products"
          :tabs="categoryTabs"
          :initialTab="activeProductTab"
          @tab-change="handleProductTabChange"
        >
          <template #default="{ activeTab: activeProductTab }">
            <div class="product-grid">
              <ProductComponent
                :key="activeProductTab"
                :groupName="activeProductTab === 'all' ? undefined : activeProductTab"
                :showPopular="activeProductTab === 'all'"
              />
            </div>
          </template>
        </MenuComponent>
      </section>
    </template>
  </div>
</template>

<script lang="ts">
import { ref, onMounted } from 'vue'
import { useProductStore } from '@/stores/products'
import CategoryComponent from '@/components/CategoryComponent.vue'
import PromotionComponent from '@/components/PromotionComponent.vue'
import MenuComponent from '@/components/MenuComponent.vue'
import ProductComponent from '@/components/ProductComponent.vue'

export default {
  name: 'App',
  components: {
    CategoryComponent,
    PromotionComponent,
    MenuComponent,
    ProductComponent,
  },

  setup() {
    const store = useProductStore()
    const activeCategoryTab = ref('all')
    const activeProductTab = ref('all')

    const categoryTabs = [
      { id: 'all', label: 'All' },
      { id: 'Group A', label: 'Milks & Dairies' },
      { id: 'Group B', label: 'Coffees & Teas' },
      { id: 'Group C', label: 'Pet Foods' },
      { id: 'Group D', label: 'Meats' },
      { id: 'Group E', label: 'Vegetables' },
      { id: 'Group F', label: 'Fruits' },
    ]

    const retryLoading = () => {
      store.errorMessage = ''
      store.fetchAllData()
    }

    const handleCategoryTabChange = (tabId: string) => {
      activeCategoryTab.value = tabId
    }

    const handleProductTabChange = (tabId: string) => {
      activeProductTab.value = tabId
    }

    onMounted(() => {
      store.fetchAllData()
    })

    return {
      store,
      retryLoading,
      activeCategoryTab,
      activeProductTab,
      categoryTabs,
      handleCategoryTabChange,
      handleProductTabChange,
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
