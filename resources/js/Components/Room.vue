<template>
    <div class="container-xxl py-5">
      <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
          <h6 class="section-title text-center text-primary text-uppercase">Our Rooms</h6>
          <h1 class="mb-5">Explore Our <span class="text-primary text-uppercase">Rooms</span></h1>
        </div>
        <div class="row g-4">
          <RoomItem
            v-for="(room, index) in rooms"
            :key="index"
            :room="room"
            :delay="index * 0.2"
          />
        </div>
      </div>
    </div>
</template>
  
<script>
  import RoomItem from './RoomItem.vue';
  import "@/css/room.css";

  export default {
    
    props: {
      rooms: {
        type: Array,
        required: true,
      }
    },
    components: {
      RoomItem
    },
    data() {
      
    }
  }
</script>
  
<style scoped>
  /* Add any scoped styles if necessary */
  </style>