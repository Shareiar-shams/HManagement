<template>
    <Navbar />
    <div class="error-container">
      <img :src="notFoundImage" alt="Page Not Found" class="error-image" />
      <h1 class="error-title">{{message}}</h1>
      <Link :href="route('main')" class="error-button">
        <button>Go Back Home</button>
      </Link>
    </div>
</template>

<script>
  import Navbar from "@/Components/Layout.vue";
  import { Link } from '@inertiajs/vue3';
  import notFoundImage from '@/assets/images/505.jpg';

  export default {
    name: "Erro",
    
    props:{
    	message:{
    		type: String,
	        required: true,
    	}
    }
    components: {
      	Link, Navbar
    },
    data() {
      return {
        notFoundImage,  // No need to add this if you want to use it directly
      };
    },
  };

</script>
  
<style scoped>
  

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
