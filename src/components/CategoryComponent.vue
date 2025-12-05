<template>
  <div class="category-container">
    <div
      class="category"
      v-for="(item, index) in categories"
      :key="index"
      :style="{ backgroundColor: item.color }"
    >
      <img :src="getImagePath(item.image)" alt="Category Image" />
      <h1>{{ item.name }}</h1>
      <p class="item-count">{{ getProductCount(item.id) }} items</p>
      <p class="description">{{ item.description }}</p>
    </div>
  </div>
</template>

<script lang="ts">
import { mapState } from 'pinia'
import { useProductStore } from '@/stores/products'
import axios from 'axios'

export default {
  name: 'CategoryComponent',
  props: {
    groupName: {
      type: String,
      default: 'Group A',
    },
  },
  data() {
    return {
      currentGroupName: this.groupName,
    }
  },
  computed: {
    ...mapState(useProductStore, {
      popularProducts: 'getPopularProducts',
      allCategories: (state) => state.categories,
      allProducts: (state) => state.products,
    }),
    categories() {
      return this.allCategories
    },
  },
  methods: {
    getProductCount(categoryId: number | string | undefined) {
      if (!categoryId) return 0
      return this.allProducts.filter((product) => product.categoryId == categoryId).length
    },
    getImagePath(imagePath: string) {
      // Convert API path to Vite asset path
      if (imagePath && imagePath.includes('/src/assets/images/')) {
        const fileName = imagePath.split('/').pop()
        return `/src/assets/images/${fileName}`
      }
      return imagePath || '/default-image.png'
    },

    // Post new category to API
    async postCategory(categoryData: {
      name: string
      description: string
      image: string
      color: string
      group?: string
    }) {
      try {
        const response = await axios.post('http://localhost:3000/api/categories', categoryData, {
          headers: {
            'Content-Type': 'application/json',
          },
        })

        // Refresh categories from store
        const store = useProductStore()
        await store.fetchAllData()

        console.log('Category created successfully:', response.data)
        return response.data
      } catch (error) {
        console.error('Error creating category:', error)
        throw error
      }
    },

    // Update existing category
    async updateCategory(
      categoryId: number | string,
      categoryData: {
        name?: string
        description?: string
        image?: string
        color?: string
        group?: string
      },
    ) {
      try {
        const response = await axios.put(
          `http://localhost:3000/api/categories/${categoryId}`,
          categoryData,
          {
            headers: {
              'Content-Type': 'application/json',
            },
          },
        )

        // Refresh categories from store
        const store = useProductStore()
        await store.fetchAllData()

        console.log('Category updated successfully:', response.data)
        return response.data
      } catch (error) {
        console.error('Error updating category:', error)
        throw error
      }
    },

    // Delete category
    async deleteCategory(categoryId: number | string) {
      try {
        const response = await axios.delete(`http://localhost:3000/api/categories/${categoryId}`)

        // Refresh categories from store
        const store = useProductStore()
        await store.fetchAllData()

        console.log('Category deleted successfully:', response.data)
        return response.data
      } catch (error) {
        console.error('Error deleting category:', error)
        throw error
      }
    },

    // Example usage method
    async addSampleCategory() {
      const newCategory = {
        name: 'Sample Category',
        description: 'This is a sample category created via API',
        image: 'sample-category.png',
        color: '#4CAF50',
        group: 'Group A',
      }

      await this.postCategory(newCategory)
    },

    // Post category with any image - flexible method
    async postCategoryWithImage(
      categoryName: string,
      description: string,
      imagePath: string,
      color: string = '#4CAF50',
      group: string = 'Group A',
    ) {
      try {
        // First upload the image file
        const store = useProductStore()
        const imageImport = await import(`@/assets/images/${imagePath}`)
        const imageFile = await store.importImageAsFile(imageImport.default, imagePath)
        await store.postImage(imageFile, 'category_image')

        // Then create the category
        const categoryData = {
          name: categoryName,
          description: description,
          image: imagePath,
          color: color,
          group: group,
        }

        const result = await this.postCategory(categoryData)
        console.log(`Category '${categoryName}' created with image:`, result)
        return result
      } catch (error) {
        console.error(`Failed to create category '${categoryName}':`, error)
        throw error
      }
    },

    // Post category with JSON only (no image upload)
    async postCategoryOnly(
      categoryName: string,
      description: string,
      imagePath: string,
      color: string = '#4CAF50',
      group: string = 'Group A',
    ) {
      const categoryData = {
        name: categoryName,
        description: description,
        image: imagePath,
        color: color,
        group: group,
      }

      try {
        const result = await this.postCategory(categoryData)
        console.log(`Category '${categoryName}' created:`, result)
        return result
      } catch (error) {
        console.error(`Failed to create category '${categoryName}':`, error)
        throw error
      }
    },

    // Generic method to post any category with any image
    async postAnyCategory(categoryData: {
      name: string
      description: string
      imagePath: string
      color?: string
      group?: string
      uploadImage?: boolean
    }) {
      const {
        name,
        description,
        imagePath,
        color = '#4CAF50',
        group = 'Group A',
        uploadImage = true,
      } = categoryData

      if (uploadImage) {
        return await this.postCategoryWithImage(name, description, imagePath, color, group)
      } else {
        return await this.postCategoryOnly(name, description, imagePath, color, group)
      }
    },
  },
}
</script>

<style scoped>
.item-count {
  color: #666;
  font-size: 0.9em;
  margin: 5px 0;
}

.description {
  color: #555;
  font-size: 0.9em;
  margin-top: 10px;
}
.category-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
  margin: 20px 0;
  font-size: small;
  color: black;
}
.category {
  text-align: center;
  margin: 10px;
  border-radius: 10px;
}
.category h1 {
  font-size: 14px;
  margin-top: 10px;
}
.category p {
  font-size: 12px;
  color: gray;
}
.category img {
  width: 80px;
  height: 80px;
  border-radius: 10px;
}
@media (max-width: 768px) {
  .category {
    width: calc(33.33% - 20px); /* 3 items per row */
  }
}
@media (max-width: 480px) {
  .category {
    width: calc(50% - 20px); /* 2 items per row */
  }
}
</style>
