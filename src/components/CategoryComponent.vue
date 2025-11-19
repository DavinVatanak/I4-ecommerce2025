<template>
  <div class="category-container">
    <div
      class="category"
      v-for="(item, index) in displayedCategories"
      :key="index"
      :style="{ backgroundColor: item.color }"
    >
      <img :src="item.image || '/default-image.png'" alt="Category Image" />
      <h1>{{ item.name }}</h1>
      <p>{{ item.description }}</p>
    </div>
  </div>
</template>

<script lang="ts">
export default {
  name: 'CategoryComponent',
  props: {
    displayedCategories: {
      type: Array,
      required: true,
    },
  },
}
</script>

<style scoped>
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
