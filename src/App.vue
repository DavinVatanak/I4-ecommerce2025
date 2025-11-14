<template>
  <main>
    <section class="categories">
      <CategoryComponent
        v-for="c in categories"
        :key="c.name"
        :title="c.name"
        :subtitle="c.subtitle"
        :bgColor="c.color"
        :image="c.image"
      />
    </section>
    <section class="promotions">
      <PromotionComponent
        v-for="p in promotions"
        :key="p.title"
        :subtitle="p.title"
        :image="p.image"
        :bgColor="p.color"
        :buttonVariant="p.buttonColor"
        :imageClass="p.imageClass"
        :buttonText="p.buttonText"
        :promotion="p"
      />
    </section>
  </main>
</template>

<script lang="ts">
// import { ref } from 'vue'
import CategoryComponent from './components/CategoryComponent.vue'
import PromotionComponent from './components/PromotionComponent.vue'
import axios from 'axios'

const API_BASE = import.meta.env.VITE_API_BASE_URL || 'http://localhost:3000'

interface CategoryApi {
  name?: string
  subtitle?: string
  productCount?: number
  image?: string
  color?: string
}

interface PromotionApi {
  title?: string
  color?: string
  image?: string
  buttonColor?: string
  url?: string
  buttonText?: string
  imageClass?: string
}

export default {
  components: { CategoryComponent, PromotionComponent },
  data() {
    return {
      categories: [
        {
          name: 'Hamburger',
          subtitle: '14 items',
          image: new URL('@/assets/images/Burger.png', import.meta.url).href,
          color: '#F2FCE4',
        },
        {
          name: 'Peach',
          subtitle: '17 items',
          image: new URL('@/assets/images/Peach.png', import.meta.url).href,
          color: '#FFFCEB',
        },
        {
          name: 'Oganic Kiwi',
          subtitle: '21 items',
          image: new URL('@/assets/images/Kiwi.png', import.meta.url).href,
          color: '#ECFFEC',
        },
        {
          name: 'Red Apple',
          subtitle: '68 items',
          image: new URL('@/assets/images/Apple.png', import.meta.url).href,
          color: '#FEEFEA',
        },
        {
          name: 'Snack',
          subtitle: '34 items',
          image: new URL('@/assets/images/Snack.png', import.meta.url).href,
          color: '#FFF3EB',
        },
        {
          name: 'Black plum',
          subtitle: '25 items',
          image: new URL('@/assets/images/Grape.png', import.meta.url).href,
          color: '#FFF3FF',
        },
        {
          name: 'Vegatables',
          subtitle: '65 items',
          image: new URL('@/assets/images/Vegetable.png', import.meta.url).href,
          color: '#F2FCE4',
        },
        {
          name: 'Headphone',
          subtitle: '33 items',
          image: new URL('@/assets/images/Headphone.png', import.meta.url).href,
          color: '#FFFCEB',
        },
        {
          name: 'Cake & Milk',
          subtitle: '54 items',
          image: new URL('@/assets/images/Cake.png', import.meta.url).href,
          color: '#F2FCE4',
        },
        {
          name: 'Orange',
          subtitle: '63 items',
          image: new URL('@/assets/images/Orange.png', import.meta.url).href,
          color: '#FFF3FF',
        },
      ],
      promotions: [
        {
          title: 'Everyday Fresh & Clean with Our Products',
          color: '#F0E8D5',
          image: new URL('@/assets/images/Onion.png', import.meta.url).href,
          buttonColor: 'green',
          url: '/products/onion',
          buttonText: 'Shop Now',
          imageClass: 'onion-image',
        },
        {
          title: 'Make your Breakfast Healthy and Easy',
          color: '#F3E8E8',
          image: new URL('@/assets/images/StrawberryMilk.png', import.meta.url).href,
          buttonColor: 'green',
          url: '/products/strawberry-milk',
          buttonText: 'Shop Now',
          imageClass: 'strawberry-milk-image',
        },
        {
          title: 'The Best Organic Products Online',
          color: '#E7EAF3',
          image: new URL('@/assets/images/VegetablePack.png', import.meta.url).href,
          buttonColor: 'yellow',
          url: '/products/vegetable-pack',
          buttonText: 'Shop Now',
          imageClass: 'vegetable-pack-image',
        },
      ],
    }
  },
  methods: {
    toUrl(s?: string) {
      if (typeof s !== 'string' || !s) return ''
      const normalized = s.replace(/\\\\/g, '/').replace(/\\\\/g, '/').replace(/\\/g, '/').replace(/\\/g, '/')
      return normalized.startsWith('http') ? normalized : `${API_BASE}/${normalized.replace(/^\//, '')}`
    },
    async fetchCategories() {
      try {
        const res = await axios.get(`${API_BASE}/api/categories`)
        this.categories = Array.isArray(res.data)
          ? res.data.map((c: CategoryApi) => ({
              name: typeof c.name === 'string' ? c.name : '',
              subtitle:
                c.subtitle ?? (typeof c.productCount === 'number' ? `${c.productCount} items` : ''),
              image: this.toUrl(c.image),
              color: c.color ?? '#ffffff',
            }))
          : []
      } catch (err) {
        console.error('Error fetching categories:', err)
      }
    },
    async fetchPromotions() {
      try {
        const res = await axios.get(`${API_BASE}/api/promotions`)
        console.log('Fetch promotions:', res.data)
        this.promotions = Array.isArray(res.data)
          ? res.data.map((p: PromotionApi) => ({
              title: typeof p.title === 'string' ? p.title : '',
              color: p.color ?? '#ffffff',
              image: this.toUrl(p.image),
              buttonColor: p.buttonColor ?? 'green',
              url: p.url ?? '#',
              buttonText: p.buttonText ?? 'Shop Now',
              imageClass: p.imageClass ?? '',
            }))
          : []
      } catch (err) {
        console.error('Error fetching promotions:', err)
      }
    },
  },
  mounted() {
    this.fetchCategories()
    this.fetchPromotions()
  },
}

// Import images so the bundler resolves them
// import burgerImg from '@/assets/images/Burger.png'
// import peachImg from '@/assets/images/Peach.png'
// import kiwiImg from '@/assets/images/Kiwi.png'
// import appleImg from '@/assets/images/Apple.png'
// import snackImg from '@/assets/images/Snack.png'
// import grapeImg from '@/assets/images/Grape.png'
// import vegetableImg from '@/assets/images/Vegetable.png'
// import headphoneImg from '@/assets/images/Headphone.png'
// import cakeImg from '@/assets/images/Cake.png'
// import orangeImg from '@/assets/images/Orange.png'
// import onionImg from '@/assets/images/Onion.png'
// import strawberryMilkImg from '@/assets/images/StrawberryMilk.png'
// import vegetablePackImg from '@/assets/images/VegetablePack.png'

// interface Category {
//   title: string
//   subtitle?: string
//   img: string
//   color: string
// }

// interface Promotion {
//   title: string
//   image: string
//   btnText: string
//   buttonColor: string
//   color: string
//   imageClass?: string
// }

// --- Placeholder categories data ---

// --- Promotions data ---
</script>

<style>
/* Add some global styles to main.css or here */
body {
  font-family: Arial, sans-serif;
  background-color: #fff;
}

main {
  max-width: 1584px;
  margin: 0 auto;
  padding: 20px;
}

.categories {
  display: grid;
  grid-template-columns: repeat(10, 1fr);
  gap: 20px;
  width: 136px;
  height: 185px;
}

.promotions {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  margin-top: 40px;
  width: 1380px;
  height: 300px;
}
</style>
