<template>
    <div class="slider">
      <div class="slides" :style="{ transform: `translateX(-${currentIndex * 100}%)` }">
        <div class="slide" v-for="(image, index) in images" :key="index">
          <img :src="image" alt="Hotel Image" />
        </div>
      </div>
      <button class="prev" @click="prevSlide">❮</button>
      <button class="next" @click="nextSlide">❯</button>
    </div>
</template>
  
<script>

  export default {
    props: {
      images: {
        type: Array,
        required: true,
      },
    },
    data() {
      return {
        currentIndex: 0,
      };
    },
    methods: {
      nextSlide() {
        this.currentIndex = (this.currentIndex + 1) % this.images.length;
      },
      prevSlide() {
        this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
      },
    },
  };
</script>
  
<style scoped>
  .slider {
    position: relative;
    overflow: hidden;
    width: 100%;
    margin: auto;
  }
  
  .slides {
    display: flex;
    transition: transform 0.5s ease;
  }
  
  .slide {
    min-width: 100%;
    max-height: 300px;
  }
  
  img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  
  button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(255, 255, 255, 0.7);
    border: none;
    cursor: pointer;
    padding: 10px;
    z-index: 10;
  }
  
  .prev {
    left: 10px;
  }
  
  .next {
    right: 10px;
  }
</style>