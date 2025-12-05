<template>
  <div class="product-container">
    <h2>Products</h2>

    <!-- Loading and Error States -->
    <div v-if="productStore.isLoading" class="loading">Loading products...</div>
    <div v-else-if="productStore.errorMessage" class="error">
      {{ productStore.errorMessage }}
    </div>

    <!-- Products Grid -->
    <div v-else class="products">
      <div v-for="product in displayProducts" :key="product.id" class="product-item">
        <div class="product-image">
          <img :src="product.image" :alt="product.name" />
        </div>
        <div class="product-info">
          <h3>{{ product.name }}</h3>
          <p class="description">{{ product.description }}</p>
          <p class="price">${{ product.price }}</p>
          <p v-if="product.countSold" class="sold-count">Sold: {{ product.countSold }}</p>
          <button class="add-to-cart" @click="addToCart(product)">Add to Cart</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, defineProps } from 'vue'
import { useProductStore } from '@/stores/products'
import type { Product } from '@/stores/products'

interface Props {
  categoryId?: number
  groupName?: string
  showPopular?: boolean
}

const props = defineProps<Props>()
const productStore = useProductStore()

const displayProducts = computed(() => {
  if (props.categoryId) {
    return productStore.getProductsByCategory(props.categoryId)
  }
  if (props.groupName) {
    return productStore.getProductsByGroup(props.groupName)
  }
  if (props.showPopular) {
    return productStore.getPopularProducts
  }
  return productStore.products
})

const addToCart = (product: Product) => {
  console.log('Added to cart:', product.name)
  // TODO: Implement cart functionality
}
</script>

<style scoped>
.product-container {
  padding: 20px;
}

.loading,
.error {
  text-align: center;
  padding: 20px;
  color: #666;
}

.error {
  color: red;
}

.products {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 20px;
}

.product-item {
  border: 1px solid #ddd;
  border-radius: 8px;
  overflow: hidden;
  transition: all 0.3s ease;
}

.product-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.product-image {
  width: 100%;
  height: 200px;
  overflow: hidden;
}

.product-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.product-info {
  padding: 15px;
}

.product-info h3 {
  margin: 0 0 10px 0;
  color: #333;
  font-size: 1.1em;
}

.description {
  color: #666;
  font-size: 0.9em;
  margin: 0 0 10px 0;
  line-height: 1.4;
}

.price {
  font-weight: bold;
  color: #007bff;
  font-size: 1.2em;
  margin: 0 0 5px 0;
}

.sold-count {
  color: #28a745;
  font-size: 0.8em;
  margin: 0 0 15px 0;
}

.add-to-cart {
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.add-to-cart:hover {
  background-color: #0056b3;
}
</style>
