<template>
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="navbar-container">
        <Link :href="route('main')" class="navbar-logo">HManagement</Link>
        <div class="menu-wrapper">
          <div class="navbar-toggle" @click="toggleMenu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
          </div>
          <ul :class="['navbar-menu', { 'active': isMenuOpen }]">
            <li class="navbar-item">
              <Link
                  :href="route('main')"
                  class="navbar-link"
              >
                  Home
              </Link>

            </li>
            <li class="navbar-item">
              <Link
                  :href="route('rooms')"
                  class="navbar-link"
              >
                  Rooms
              </Link>
            </li>
            
            <li class="navbar-item">
              <Link
                v-if="isAuthenticated"
                :href="route('dashboard')"
                class="navbar-link"
              >
                Dashboard
              </Link>
              <Link
                v-else
                :href="route('login')"
                class="navbar-link"
              >
                Login
              </Link>
            </li>
          </ul>
        </div>
      </div>
    </nav>

  
</template>
<script setup>
import { Link } from '@inertiajs/vue3';

</script>

<script>
export default {
  name: 'Navbar',
  props: {
    isAuthenticated: {
      type: Boolean,
      required: true,
    },
  },
  components: {
    Link,
  },
  data() {
    return {
      isMenuOpen: false,
    };
  },
  methods: {
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },
  },
};
</script>

<style scoped>
    .navbar {
      background-color: #043580;
      color: white;
      padding: 20px 50px;
      width: 100%;
    }

    .navbar-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .menu-wrapper {
      display: flex;
      align-items: center;
    }

    .navbar-logo {
      color: #fff;
      text-decoration: none;
      font-size: 1.5rem;
    }

    .navbar-menu {
      list-style: none;
      display: flex;
      gap: 1rem;
      transition: max-height 0.3s ease-in-out;
    }

    .navbar-item {
      margin: 0;
    }

    .navbar-link {
      color: #fff;
      text-decoration: none;
      padding: 0.5rem 1rem;
      transition: background-color 0.3s;
    }

    .navbar-link:hover {
      background-color: #555;
    }

    /* Hamburger menu styles */
    .navbar-toggle {
      display: none;
      flex-direction: column;
      cursor: pointer;
    }

    .bar {
      height: 3px;
      width: 25px;
      background-color: white;
      margin: 3px 0;
    }

    @media (max-width: 768px) {
        .navbar-menu {
            display: none; /* Hide menu by default */
            flex-direction: column;
            position: absolute;
            top: 60px; /* Adjust based on navbar height */
            left: 0;
            right: 0;
            background-color: #333;
            max-height: 0; /* Initially collapsed */
            overflow: hidden;
            z-index: 1000; /* Add z-index to bring it to the front */
        }

        .navbar-menu.active {
            display: flex; /* Show menu when active */
            max-height: 300px; /* Adjust as needed */
        }

        .navbar-toggle {
            display: flex; /* Show toggle button */
        }
    }
</style>