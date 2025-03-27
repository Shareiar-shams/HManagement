<template>
    <Navbar />
    <div v-if="error" class="error-container">
      <img :src="notFoundImage" alt="Page Not Found" class="error-image" />
      <h1 class="error-title">Oops! Page Not Found</h1>
      <p class="error-message">{{ error }}</p>
      <Link :href="route('main')" class="error-button">
        <button>Go Back Home</button>
      </Link>
    </div>
    <div v-else>

      <div class="main">
        <!-- This part shows the guest preferences based on inputs in home page -->
        <div class="search-area">
          <h2>Search</h2>
          <div v-if="guestData.floorName" class="w-100 mb-1">
            <label> Floor: </label>
            <div class="search-input d-flex align-items-center ps-2">
              <svg
                aria-hidden="true"
                fill="#333333"
                focusable="false"
                height="20"
                role="presentation"
                width="20"
                viewBox="0 0 24 24"
              >
                <path
                  d="M17.464 6.56a8.313 8.313 0 1 1-15.302 6.504A8.313 8.313 0 0 1 17.464 6.56zm1.38-.586C16.724.986 10.963-1.339 5.974.781.988 2.9-1.337 8.662.783 13.65c2.12 4.987 7.881 7.312 12.87 5.192 4.987-2.12 7.312-7.881 5.192-12.87zM15.691 16.75l7.029 7.03a.75.75 0 0 0 1.06-1.06l-7.029-7.03a.75.75 0 0 0-1.06 1.06z"
                ></path>
              </svg>
              <div class="result ms-3">{{ guestData.floorName }}</div>
            </div>
          </div>
          <div class="w-100 mb-1">
            <label> Check-in date </label>
            <div class="search-input d-flex align-items-center ps-2">
              <svg
                aria-hidden="true"
                fill="#333333"
                focusable="false"
                height="20"
                role="presentation"
                width="20"
                viewBox="0 0 24 24"
              >
                <path
                  d="M22.502 13.5v8.25a.75.75 0 0 1-.75.75h-19.5a.75.75 0 0 1-.75-.75V5.25a.75.75 0 0 1 .75-.75h19.5a.75.75 0 0 1 .75.75v8.25zm1.5 0V5.25A2.25 2.25 0 0 0 21.752 3h-19.5a2.25 2.25 0 0 0-2.25 2.25v16.5A2.25 2.25 0 0 0 2.252 24h19.5a2.25 2.25 0 0 0 2.25-2.25V13.5zm-23.25-3h22.5a.75.75 0 0 0 0-1.5H.752a.75.75 0 0 0 0 1.5zM7.502 6V.75a.75.75 0 0 0-1.5 0V6a.75.75 0 0 0 1.5 0zm10.5 0V.75a.75.75 0 0 0-1.5 0V6a.75.75 0 0 0 1.5 0z"
                ></path>
              </svg>
              <div class="result ms-3">{{ guestData.checkinDate }}</div>
            </div>
          </div>
          <div class="w-100 mb-1">
            <label> Check-out date</label>
            <div class="search-input d-flex align-items-center ps-2 mb-1">
              <svg
                aria-hidden="true"
                fill="#333333"
                focusable="false"
                height="20"
                role="presentation"
                width="20"
                viewBox="0 0 24 24"
              >
                <path
                  d="M22.502 13.5v8.25a.75.75 0 0 1-.75.75h-19.5a.75.75 0 0 1-.75-.75V5.25a.75.75 0 0 1 .75-.75h19.5a.75.75 0 0 1 .75.75v8.25zm1.5 0V5.25A2.25 2.25 0 0 0 21.752 3h-19.5a2.25 2.25 0 0 0-2.25 2.25v16.5A2.25 2.25 0 0 0 2.252 24h19.5a2.25 2.25 0 0 0 2.25-2.25V13.5zm-23.25-3h22.5a.75.75 0 0 0 0-1.5H.752a.75.75 0 0 0 0 1.5zM7.502 6V.75a.75.75 0 0 0-1.5 0V6a.75.75 0 0 0 1.5 0zm10.5 0V.75a.75.75 0 0 0-1.5 0V6a.75.75 0 0 0 1.5 0z"
                ></path>
              </svg>
              <div class="result ms-3">{{ guestData.checkoutDate }}</div>
            </div>
            <small class="d-block">{{ guestData.days }} night stay</small>
          </div>
          
          <div class="d-flex gap-2 w-100 mb-2">
            <div class="result search-input w-50 d-flex align-items-center ps-2">
              {{ guestData.adult }} adults
            </div>

            <div class="result search-input w-50 d-flex align-items-center ps-2">
              {{ guestData.children }} children
            </div>
          </div>

          <Link :href="route('main')">
            <button class="search-btn">Change</button>
          </Link>

        </div>
        <!-- No Data Found Message -->
        <div v-if="rooms && rooms.length === 0" class="no-data-container">
            <img :src="notFoundImage" alt="No Data Found" class="no-data-image" />
            <h2 class="no-data-title">No Rooms Available</h2>
            <p class="no-data-message">
              Sorry, we couldn't find any rooms matching your search criteria.
            </p>
            <Link :href="route('main')" class="no-data-button">
              <button>Go Back to Search</button>
            </Link>
        </div>

        <!-- Room Cards -->
        <div v-else class="card-container">
          <h3 v-if="guestData.floorName" class="header mb-3">
            {{ guestData.floorName }}: {{ rooms.length }} Room(s) Found
          </h3>

          <h3 v-else class="header mb-3">
            {{ rooms.length }} Room(s) Found
          </h3>

          <Card
            v-for="room in rooms"
            :key="room.id"
            :room="room"
            :guestData="guestData"
          />
        </div>

      </div>
    </div>
</template>
  
<script>
    import Card from "@/Components/Card.vue";
    import Navbar from "@/Components/Layout.vue";
    import { Link } from '@inertiajs/vue3';
    import notFoundImage from '@/assets/images/404.png';

    export default {
      name: "HotelResults",
      props: {
        rooms: {
          type: Array,
          required: true,
        },
        guestData: {
          type: Object,
          default: () => ({}), 
        },
        error: {
          type: String,
          default: 'The page you are looking for does not exist.',
        },
      },
      
      components: {
        Card, Link, Navbar
      },
      data() {
        return {
          notFoundImage,  // No need to add this if you want to use it directly
        };
      },
    };

</script>
  
<style scoped>
  .main {
      min-height: 100vh;
      display: grid;
      column-gap: 30px;
      grid-template-columns: repeat(4, 1fr);
      background-color: #f5f5f5;
      padding: 120px 70px 50px 70px;
  }
  .search-area {
      position: relative;
      background-color: #fcbb01;
      width: 100%;
      height: 100%;
      max-width: 320px;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  /* Aligns the container properly in the grid */
  .card-container {
      grid-column-start: 2;
      grid-column-end: 5;
  }

  /* Input Field Styles */
  .search-input {
      height: 40px;
      background-color: white;
      border-radius: 5px;
      display: flex;
      align-items: center;
      padding: 0 10px;
      border: 1px solid #ddd;
      box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease-in-out;
  }

  /* Icons & Text inside search-input */
  .search-input svg {
      flex-shrink: 0;
  }

  .result {
      font-size: 14px;
      font-weight: 500;
      color: #333;
  }

  /* Button Styling */
  .search-btn {
      width: 100%;
      height: 50px;
      background-color: #1471c2;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease-in-out;
  }

  .search-btn:hover {
      background-color: #125a9d;
  }

  /* Labels & Small Text */
  label,
  small {
      font-size: 12px;
      font-weight: 400;
      color: #444;
  }

  /* Headings */
  h2 {
      font-size: 22px;
      font-weight: 600;
      color: rgb(51, 51, 51);
      margin-bottom: 10px;
  }

  .header {
      font-size: 24px;
      font-weight: 700;
  }

  /* Grid for better spacing */
  .d-flex.gap-2 {
      display: flex;
      justify-content: space-between;
  }

  /* Responsive Design */
  @media screen and (max-width: 768px) {
      .search-area {
          width: 100%;
          max-width: none;
          padding: 15px;
          height: auto;
      }

      .search-input {
          height: 36px;
      }

      .search-btn {
          height: 45px;
      }
  }

  

  .error-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 50px 20px;
  }

  .error-image {
    width: 400px;
    max-width: 100%;
    margin-bottom: 20px;
  }

  .error-title {
    font-size: 32px;
    color: #ff6b6b;
    margin-bottom: 10px;
  }

  .error-message {
    font-size: 18px;
    color: #666;
    margin-bottom: 20px;
  }

  .error-button button {
    background-color: #ff6b6b;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .error-button button:hover {
    background-color: #e55b5b;
  }

  </style>
  