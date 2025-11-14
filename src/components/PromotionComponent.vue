<template>
  <div class="promo-card" :style="{ backgroundColor: bgColor }">
    <div class="text-content">
      <h2>{{ subtitle }}</h2>
      <ButtonComponent :text="buttonText" :variant="buttonVariant" @click="shopNow()" />
    </div>
    <img :src="image" :alt="subtitle" :class="['promo-image', imageClass]" />
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import ButtonComponent from './ButtonComponent.vue'

export default defineComponent({
  components: { ButtonComponent },

  props: {
    subtitle: String,
    buttonText: String,
    image: String,
    bgColor: String,
    buttonVariant: String,
    imageClass: {
      type: [String, Array, Object],
      default: () => [],
    },
    promotion: {
      type: Object,
      required: true,
    },
  },
  methods: {
    shopNow() {
      if (!this.promotion.title) return
      alert("Let's shop: " + this.promotion.title)
    },
  },
})
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
