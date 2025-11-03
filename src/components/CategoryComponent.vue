<template>
  <div class="category-card" :style="{ backgroundColor: bgColor }">
    <img :src="imageScr" :alt="title" />
    <p class="title">{{ title }}</p>
    <p v-if="subtitle" class="subtitle">{{ subtitle }}</p>
  </div>
</template>

<script setup lang="ts">
defineProps({
  title: String,
  bgColor: String,
  imageScr: String,
  subtitle: String,
})
</script>

<style>
.category-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  /* justify-content: center; */
  padding: 5% 10px;
  border-radius: 10px;
  text-align: center;
  width: 120px;
}

.category-card img {
  width: 120px;
  height: 120px;
  object-fit: contain;
  margin: 0;
  margin-top: -8px;
}

.category-card p {
  margin: 6px 0 0 0;
  padding: 0;
  text-decoration: none;
  border: none;
  border-bottom: none;
  font-size: 14px;
  font-weight: 500;
  color: #253d4e;
  line-height: 1.4;
}

.category-card .title {
  font-size: 14px;
}

.category-card .subtitle {
  font-size: 12px;
  opacity: 0.5;
  margin-top: 2px;
}
</style>
