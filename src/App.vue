<template>
  <main>
    <section class="categories">
      <CategoryComponent
        v-for="category in categories"
        :key="category.title"
        :title="category.title"
        :subtitle="category.subtitle"
        :bgColor="category.color"
        :imageScr="category.img"
      />
    </section>
    <section class="promotions">
      <PromotionComponent
        v-for="promo in promotions"
        :key="promo.subtitle"
        :subtitle="promo.subtitle"
        :imageSrc="promo.img"
        :bgColor="promo.color"
        :buttonText="promo.btnText"
        :buttonVariant="promo.btnVariant"
        :imageClass="promo.imageClass"
      />
    </section>
  </main>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import CategoryComponent from './components/CategoryComponent.vue'
import PromotionComponent from './components/PromotionComponent.vue'

// Import images so the bundler resolves them
import burgerImg from '@/assets/images/Burger.png'
import peachImg from '@/assets/images/Peach.png'
import kiwiImg from '@/assets/images/Kiwi.png'
import appleImg from '@/assets/images/Apple.png'
import snackImg from '@/assets/images/Snack.png'
import grapeImg from '@/assets/images/Grape.png'
import vegetableImg from '@/assets/images/Vegetable.png'
import headphoneImg from '@/assets/images/Headphone.png'
import cakeImg from '@/assets/images/Cake.png'
import orangeImg from '@/assets/images/Orange.png'
import onionImg from '@/assets/images/Onion.png'
import strawberryMilkImg from '@/assets/images/StrawberryMilk.png'
import vegetablePackImg from '@/assets/images/VegetablePack.png'

interface Category {
  title: string
  subtitle?: string
  img: string
  color: string
}

interface Promotion {
  subtitle: string
  img: string
  btnText: string
  btnVariant: string
  color: string
  imageClass?: string
}

// --- Placeholder categories data ---
const categories = ref<Category[]>([
  { title: 'Hamburger', subtitle: '14 items', img: burgerImg, color: '#F2FCE4' },
  { title: 'Peach', subtitle: '17 items', img: peachImg, color: '#FFFCEB' },
  { title: 'Oganic Kiwi', subtitle: '21 items', img: kiwiImg, color: '#ECFFEC' },
  { title: 'Red Apple', subtitle: '68 items', img: appleImg, color: '#FEEFEA' },
  { title: 'Snack', subtitle: '34 items', img: snackImg, color: '#FFF3EB' },
  { title: 'Black plum', subtitle: '25 items', img: grapeImg, color: '#FFF3FF' },
  { title: 'Vegatables', subtitle: '65 items', img: vegetableImg, color: '#F2FCE4' },
  { title: 'Headphone', subtitle: '33 items', img: headphoneImg, color: '#FFFCEB' },
  { title: 'Cake & Milk', subtitle: '54 items', img: cakeImg, color: '#F2FCE4' },
  { title: 'Orange', subtitle: '63 items', img: orangeImg, color: '#FFF3FF' },
])

// --- Promotions data ---
const promotions = ref<Promotion[]>([
  {
    subtitle: 'Everyday Fresh & Clean with Our Products',
    img: onionImg,
    btnText: 'Shop Now',
    btnVariant: 'green',
    color: '#F0E8D5',
    imageClass: 'onion-image',
  },
  {
    subtitle: 'Make your Breakfast Healthy and Easy',
    img: strawberryMilkImg,
    btnText: 'Shop Now',
    btnVariant: 'green',
    color: '#F3E8E8',
    imageClass: 'strawberry-milk-image',
  },
  {
    subtitle: 'The Best Organic Products Online',
    img: vegetablePackImg,
    btnText: 'Shop Now',
    btnVariant: 'yellow',
    color: '#E7EAF3',
    imageClass: 'vegetable-pack-image',
  },
])
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
