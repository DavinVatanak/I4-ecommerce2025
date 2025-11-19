<template>
  <div id="app">
    <div v-if="isLoading">Loading...</div>
    <div v-if="errorMessage">{{ errorMessage }}</div>

    <section class="categories">
      <CategoryComponent :displayedCategories="categories" />
    </section>

    <section class="promotions">
      <PromotionComponent
        v-for="promotion in promotions"
        :key="promotion.url"
        :title="promotion.title"
        :color="promotion.color"
        :image="promotion.image"
        :buttonColor="promotion.buttonColor"
        :url="promotion.url"
        :promotion="promotion"
      />
    </section>
  </div>
</template>

<script>
import axios from 'axios'
import CategoryComponent from './components/CategoryComponent.vue'
import PromotionComponent from './components/PromotionComponent.vue'

export default {
  name: 'App',
  components: {
    CategoryComponent,
    PromotionComponent,
  },
  data() {
    return {
      categories: [],
      promotions: [],
      isLoading: false,
      errorMessage: '',
    }
  },

  async mounted() {
    this.isLoading = true
    this.errorMessage = ''
    try {
      const [catRes, promoRes] = await Promise.all([
        axios.get('http://localhost:3000/api/categories'),
        axios.get('http://localhost:3000/api/promotions'),
      ])

      this.categories = catRes.data
      this.promotions = promoRes.data
    } catch (err) {
      console.error(err)
      this.errorMessage = 'Unable to load data'
    } finally {
      this.isLoading = false
    }
  },
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  text-align: center;
  margin-top: 20px;
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
</style>
