<template>
    <Navbar />
    <main class="home">
      <ImageSlider :images="imageArray" />
      <h1 class="home-heading mb-0">
        Find deals on rooms, homes, and much more...
      </h1>
      <div class="input-container">
        <div class="date-input-container">
          <span style="width: 45%; text-align: center">{{ checkinDate }}</span>
          <span style="width: 10%">-</span>
          <span style="width: 45%; text-align: start">{{ checkoutDate }}</span>
          <input v-model="checkinDate" class="datepicker-input" type="date" />
          <input v-model="checkoutDate" class="datepicker-input checkout" type="date" />
        </div>
        <div class="guest-input" @mouseenter="isSelectionOpen = true" @mouseleave="isSelectionOpen = false">
          <div class="guest-input-header">
            <span class="me-2 ml-2">{{ adultNum }} Adults</span>
            <span class="me-2">-</span>
            <span class="me-2">{{ childrenNum }} Children</span>
          </div>
          <div v-show="isSelectionOpen" class="guest-input-body w-100">
            <div class="d-flex align-items-center w-100 mb-3">
              <span class="w-50">Adult</span>
              <div class="d-flex align-items-center w-50">
                <button @click="adultNum === 1 ? null : adultNum--" class="guest-btn"> - </button>
                <span class="count-span ms-3 me-3">{{ adultNum }}</span>
                <button @click="adultNum === 10 ? null : adultNum++" class="guest-btn"> + </button>
              </div>
            </div>
            <div class="d-flex align-items-center w-100 mb-3">
              <span class="w-50">Children</span>
              <div class="d-flex align-items-center w-50">
                <button @click="childrenNum === 0 ? null : childrenNum--" class="guest-btn"> - </button>
                <span class="count-span ms-3 me-3">{{ childrenNum }}</span>
                <button @click="childrenNum === 10 ? null : childrenNum++" class="guest-btn"> + </button>
              </div>
            </div>
          </div>
        </div>
        <select placeholder="Select Floor" class="floor-input" ref="floorSelect" @change="getSelectedFloor">
          <option value="" disabled selected>Select Floor</option>
          <option v-for="floor in floors" :key="floor.id" :value="floor.id"> {{ floor.name }} </option>
        </select>
        <Link class="search-button" @click="submit">
          <button>Search</button>
        </Link>
      </div>
      <Room v-if="rooms && rooms.length > 0" :rooms="rooms"/>
      <Services />
    </main>
</template>

<script setup>
    import Navbar from "@/Components/Layout.vue";
    import ImageSlider from "@/Components/ImageSlider.vue";
    import Room from "@/Components/Room.vue";
    import Services from "@/Components/Services.vue";
    import { Link, useForm } from '@inertiajs/vue3';
    import { ref, computed, onMounted } from 'vue';

    import image1 from '@/assets/img/carousel-1.jpg';
    import image2 from '@/assets/img/carousel-2.jpg';
    
    const imageArray = ref([image1, image2]);
    const props = defineProps({
      floors: {
        type: Array,
        required: false,
      },
      rooms: {
        type: Array,
        required: false,
      },
    });
    const isSelectionOpen = ref(false);
    const floorSelect = ref(null);
    const floor = ref(1);
    const checkinDate = ref(null);
    const checkoutDate = ref(null);
    const adultNum = ref(1);
    const childrenNum = ref(0);
  

    const today = () => {
      let today = new Date();
      let day = String(today.getDate()).padStart(2, '0');
      let month = String(today.getMonth() + 1).padStart(2, '0');
      let year = today.getFullYear();
      checkinDate.value = `${year}-${month}-${day}`;
    };

    const tomorrow = () => {
      let today = Date.now();
      let tomorrow = new Date(today + 86400000);
      let day = String(tomorrow.getDate()).padStart(2, '0');
      let month = String(tomorrow.getMonth() + 1).padStart(2, '0');
      let year = tomorrow.getFullYear();
      checkoutDate.value = `${year}-${month}-${day}`;
    };

    const calculateDays = computed(() => {
      let checkin = new Date(checkinDate.value);
      let checkout = new Date(checkoutDate.value);
      if (checkin >= checkout) {
        today();
        tomorrow();
        return 1;
      } else {
        let difference = checkout.getTime() - checkin.getTime();
        return difference / (1000 * 3600 * 24);
      }
    });

    const form = useForm({
      floor: null,
      adult: adultNum.value,
      children: childrenNum.value,
      days: calculateDays.value,
      checkinDate: checkinDate.value,
      checkoutDate: checkoutDate.value,
    });

    const getSelectedFloor = () => {
      if (floorSelect.value) {
        floor.value = floorSelect.value.value;
        form.floor = floor.value;
      }
    };


    const submit = () => {
      form.floor = floor.value;
      form.adult = adultNum.value;
      form.children = childrenNum.value;
      form.days = calculateDays.value;
      form.checkinDate = checkinDate.value;
      form.checkoutDate = checkoutDate.value;
      form.post(route('searchRoom'));
    };

    onMounted(() => {
      today();
      tomorrow();
    });
</script>
  
<style scoped>
  .home {
    min-height: 100vh;
    padding: 10px 60px 30px 60px;
    background-color: #f5f5f5;
    color: rgb(51, 51, 51);
  }
  .home-heading {
    font-size: 24px;
    font-weight: 600;
  }
  .home-text {
    font-size: 14px;
    font-weight: 400;
  }
  .input-container {
    width: 100%;
    border: 4px solid #fcbb01;
    border-radius: 5px;
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    margin-bottom: 50px;
  }
  .floor-input,
  .date-input-container {
    height: 52px;
    outline: none;
    border: none;
    padding-left: 50px;
    display: flex;
    align-items: center;
  }
  .floor-input {
    grid-column-start: 5;
    grid-column-end: 7;
    background-image: url("https://cf.bstatic.com/static/img/cross_product_index/accommodation/07ca5cacc9d77a7b50ca3c424ecd606114d9be75.svg");
    background-repeat: no-repeat;
    background-position-x: 15px;
    background-position-y: center;
    border-right: 4px solid #fcbb01;
  }
  .date-input-container {
    font-size: 16px;
    position: relative;
    grid-column-start: 1;
    grid-column-end: 3;
    background-color: white;
    background-image: url("https://cdn2.iconfinder.com/data/icons/web/512/Calendar-512.png");
    background-size: 20px;
    background-repeat: no-repeat;
    background-position-x: 15px;
    background-position-y: center;
    border-right: 4px solid #fcbb01;
  }
  .datepicker-input {
    position: absolute;
    left: 0;
    top: 0;
    width: 50%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    box-sizing: border-box;
  }
  .datepicker-input::-webkit-calendar-picker-indicator {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    cursor: pointer;
  }
  .checkout {
    position: absolute;
    left: 50%;
    top: 0;
    width: 50%;
  }
  .guest-input {
    position: relative;
    height: 52px;
    grid-column-start: 3;
    grid-column-end: 5;
    padding-left: 45px;
    background-color: white;
    background-image: url(//cf.bstatic.com/static/img/cross_product_index/guest/b2e5f2aa32b71ca0fc66aa671e4e958bcd69b7d0.svg);
    background-size: 16px;
    background-repeat: no-repeat;
    background-position-x: 15px;
    background-position-y: center;
    display: flex;
    align-items: center;
    cursor: pointer;
    border-right: 4px solid #fcbb01;
  }
  .guest-input-body {
    padding: 20px;
    background-color: white;
    position: absolute;
    top: 52px;
    left: 0;
  }
  .guest-btn {
    width: 40px;
    height: 40px;
    background-color: white;
    color: #005999;
    border: 1px solid #005999;
    border-radius: 3px;
  }
  .guest-btn:hover {
    color: white;
  }
  .search-button {
    grid-column-start: 7;
    grid-column-end: 8;
  }
  .count-span {
    width: 20%;
    text-align: center;
  }
  button {
    font-size: 20px;
    font-weight: 500;
    border: none;
    outline: none;
    color: white;
    background-color: #1471c2;
    height: 100%;
    width: 100%;
  }
  button:hover {
    background-color: #005999;
  }
  h2 {
    font-size: 24px;
    font-weight: 600;
    color: black;
  }
  .destination-ideas {
    width: 100%;
    min-height: 250px;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    column-gap: 20px;
  }
  .destination1 {
    background: url('@/assets/img/cat-1.jpg')
      no-repeat center center;
    background-size: cover;
  }
  .destination2 {
    background: url('@/assets/img/cat-2.jpg')
      no-repeat center center;
    background-size: cover;
  }
  .destination3 {
    background: url('@/assets/img/cat-3.jpg')
      no-repeat center center;
    background-size: cover;
  }
  .dest-name {
    background: linear-gradient(
      0deg,
      rgba(255, 255, 255, 0) 0%,
      rgba(38, 38, 38, 1) 100%
    );
    padding: 10px 20px;
    font-size: 30px;
    font-weight: 600;
    color: rgb(241, 241, 241);
    text-shadow: 1px 1px #030303;
  }
  .error {
    color: red;
  }
  
  @media only screen and (max-width: 1000px) {
    .input-container {
      grid-template-columns: 1fr;
    }
    .floor-input,
    .date-input-container,
    .guest-input {
      grid-column-start: 1;
      grid-column-end: 2;
      border-right: none;
      border-bottom: 4px solid #fcbb01;
    }
    .search-button {
      grid-column-start: 1;
      grid-column-end: 2;
      height: 52px;
    }
  }
  @media only screen and (max-width: 800px) {
    .destination-ideas {
      grid-template-columns: 1fr;
      gap: 20px;
    }
    .destination1,
    .destination2,
    .destination3 {
      height: 250px;
    }
  }
</style>
