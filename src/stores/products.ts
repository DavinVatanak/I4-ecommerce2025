import { defineStore } from 'pinia'
import axios from 'axios'

export interface Product {
  id: number
  name: string
  description: string
  price: number
  image: string
  categoryId: number
  countSold?: number
  group?: string
}

export interface Group {
  id: number
  name: string
  image: string
  products: Product[]
}
// Definitions basesd on your Componet usage
export interface Category {
  name: string
  image: string
  color: string // Used in :style="{ backgroundColor: item.color }"
  description: string // Used in <p>{{ item.description}}</p>
  // Add 'id'
  id?: number | string
  group?: string
}

export interface Promotion {
  title: string
  url: string
  image: string
  color: string // Used for background color
  buttonColor: string // Passed to button
}

export const useProductStore = defineStore('product', {
  state: () => ({
    // Add explicit types to arrays
    group: [] as Group[], // Haven't defined Group interface yet
    promotions: [] as Promotion[],
    categories: [] as Category[],
    products: [] as Product[], // Haven't defined Product interface yet

    // Move loading and error state here so the store manages it
    isLoading: false,
    errorMessage: '',
  }),
  getters: {
    getCategoriesByGroup: (state) => {
      return (groupName: string) =>
        state.categories.filter((category) => category.group === groupName)
    },
    getProductsByGroup: (state) => {
      return (groupName: string) => state.products.filter((product) => product.group === groupName)
    },
    getProductsByCategory: (state) => {
      return (categoryId: number) =>
        state.products.filter((product) => product.categoryId === categoryId)
    },
    getPopularProducts: (state) => {
      return state.products.filter((product) => (product.countSold || 0) > 10)
    },
  },
  actions: {
    async postImage(imageFile: File, fieldName = 'image') {
      try {
        // Create FormData for multipart/form-data upload
        const formData = new FormData()
        formData.append(fieldName, imageFile)

        // Post to your API endpoint (adjust the URL as needed)
        const uploadResponse = await axios.post('http://localhost:3000/api/upload', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        })

        return uploadResponse.data
      } catch (err) {
        console.error('Error uploading image:', err)
        throw err
      }
    },

    // Helper method to import and convert any image asset to File
    async importImageAsFile(imageImport: string, fileName: string) {
      try {
        const response = await fetch(imageImport)
        const blob = await response.blob()
        const file = new File([blob], fileName, { type: blob.type })
        return file
      } catch (err) {
        console.error('Error converting image to file:', err)
        throw err
      }
    },

    async fetchAllData() {
      this.isLoading = true
      this.errorMessage = ''

      try {
        // Use Promise.all to fetch all 4 endpoints at the same time
        const [catRes, promoRes, groupRes, prodRes] = await Promise.all([
          axios.get('http://localhost:3000/api/categories'),
          axios.get('http://localhost:3000/api/promotions'),
          axios.get('http://localhost:3000/api/groups'),
          axios.get('http://localhost:3000/api/products'),
        ])

        // Save the data into the state
        this.categories = catRes.data
        this.promotions = promoRes.data
        this.group = groupRes.data
        this.products = prodRes.data
      } catch (err) {
        console.error(err)
        this.errorMessage = 'Unable to load data from server'
      } finally {
        this.isLoading = false
      }
    },
  },
})
