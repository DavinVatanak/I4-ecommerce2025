<template>
  <div class="promo-card" :style="{ backgroundColor: color }">
    <div class="text-content">
      <h2>{{ title }}</h2>
      <button class="shop-button" @click="shopNow(promotion)">Shop Now</button>
    </div>
    <img :src="image" :alt="title" class="promo-image" />
  </div>
</template>

<script lang="ts">
export default {
  name: 'PromotionComponent',
  props: ['promotion', 'title', 'color', 'image', 'buttonColor', 'url'],

  methods: {
    shopNow(promo) {
      if (!promo || !promo.title) return
      alert("Let's shop: " + promo.title)
      // in a real app: this.$router.push(promo.url)
    },
  },
}
</script>

<style scoped>
.promo-card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px 0 20px 20px;
  border-radius: 15px;
  overflow: hidden;
  position: relative;
}

.text-content {
  flex: 1;
  padding-right: 260px;
  position: relative;
  z-index: 1;
}

.text-content h2 {
  margin: 0 0 15px 0;
  font-size: 18px;
  font-weight: 600;
  color: #253d4e;
  line-height: 1.4;
}

.promo-image {
  position: absolute;
  right: 0;
  bottom: 0;
  top: auto;
  transform: none;
  width: 240px;
  height: 240px;
  object-fit: contain;
  pointer-events: none;
  z-index: 0;
}

.promo-image.onion-image {
  width: 100%;
  height: 260px;
  object-position: bottom right;
}

.promo-image.strawberry-milk-image {
  width: 50%;
  height: 260px;
  object-position: bottom right;
}

.promo-image.vegetable-pack-image {
  width: 100%;
  height: 260px;
  object-position: bottom right;
}
</style>
