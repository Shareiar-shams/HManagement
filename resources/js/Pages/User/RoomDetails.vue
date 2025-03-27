<template>
	<Navbar />
   	<div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <!-- Detail Start -->
                <div class="col-lg-8">
                    <ImageSlider :images="transformedImages" />	
                    
                    <div class="d-flex align-items-center mb-4">
                        <h1 class="mb-0">{{ room.name }}</h1>
                        <div class="ps-3">
                            <span>Room Id:</span>{{ room.SKU }}
                        </div>
                    </div>

                    <div class="d-flex flex-wrap pb-4 m-n1 gap-4 bg-light p-3 rounded shadow-sm">
					    <div class="d-flex align-items-center gap-2 text-primary">
					        <i class="fa fa-user fa-lg"></i>
					        <span><strong>Adult Capacity:</strong> {{ room.adult_capacity }}</span>
					    </div>
					    <div class="d-flex align-items-center gap-2 text-success">
					        <i class="fa fa-child fa-lg"></i>
					        <span><strong>Child Capacity:</strong> {{ room.child_capacity }}</span>
					    </div>
					</div>

                    <div class="d-flex flex-wrap pb-4 m-n1">
                    	<span v-if="parsedTags && parsedTags.length > 0">
		                  <small v-for="(tag, index) in parsedTags" :key="index" class="bg-light rounded py-1 px-3 m-1">
		                  	<span class="badge badge-warning"> {{ tag }} </span>
		                    
		                  </small>
		                </span>
		                <span v-else>
		                  
		                </span>

                    </div>

                    <p class="mb-5">
                    	{{ room.short_description}}
                    </p>

                    <div class="tab-class wow fadeInUp" data-wow-delay="0.1s">
					    <ul class="nav nav-pills d-flex justify-content-between border-bottom mb-4">
					      <li class="nav-item">
					        <a
					          class="d-flex align-items-center py-3"
					          :class="{ active: activeTab === 'overview' }"
					          @click="activeTab = 'overview'"
					          href="#"
					        >
					          <i class="fa fa-eye text-primary me-2"></i>
					          <h6 class="mb-0">Overview</h6>
					        </a>
					      </li>
					      <li class="nav-item">
					        <a
					          class="d-flex align-items-center py-3"
					          :class="{ active: activeTab === 'pricing' }"
					          @click="activeTab = 'pricing'"
					          href="#"
					        >
					          <i class="fa fa-dollar text-primary me-2"></i>
					          <h6 class="mb-0">Pricing</h6>
					        </a>
					      </li>
					    </ul>

					    <div class="tab-content">
					      <!-- Overview Tab -->
					      <div v-if="activeTab === 'overview'" class="tab-pane fade show p-0 active">
					        <!-- Use v-html to render HTML content safely -->
					        <div v-html="overviewContent"></div>
					      </div>

					      <!-- Pricing Tab -->
					      <div v-show="activeTab === 'pricing'" class="tab-pane fade show p-0 active">
					        <div class="row g-4">
						        <div
						            class="col-sm-6 d-flex align-items-center justify-content-between"
						            v-for="(item, index) in computedPricingDetails"
						            :key="index"
						        >

						            <span>{{ item.label }}:</span>
						            <hr class="flex-grow-1 my-0 mx-3" />
						            <span>${{ item.price }}</span>
						        </div>
					        </div>
					      </div>
					    </div>
					</div>
                </div>
                <!-- Detail End -->
    
                <!-- Sidebar Start -->
                <div class="col-lg-4">
                    <!-- Booking Start -->
                    <div class="bg-light mb-5 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="border-bottom text-center text-dark p-3 pt-4 mb-3">
                        	<span v-if="room.special_price">

                        		<span class="align-top fs-4 lh-base"><span v-html="'&#2547;'"></span></span>

		                        <del>{{ room.price }}</del>
		                        <span class="align-middle fs-1 lh-sm fw-bold">{{ room.special_price }}</span>
		                        <span class="align-bottom fs-6 lh-lg">/ Night</span>
		                    </span>
		                    <span v-else>
		                    	<span class="align-top fs-4 lh-base"><span v-html="'&#2547;'"></span></span>
		                        <span class="align-middle fs-1 lh-sm fw-bold">{{room.price}}</span>
		                        <span class="align-bottom fs-6 lh-lg">/ Night</span>
		                    </span>

                           
                        </div>
                        <div v-if="guestData" class="search-area">
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

					        <div class="w-100 mb-1">
					            <label> Room Price</label>
					            <div class="search-input d-flex align-items-center ps-2 mb-1">
					              <svg
					                aria-hidden="true"
					                fill="#333333"
					                focusable="false"
					                height="20"
					                role="presentation"
					                width="20"
					                viewBox="0 0 320 512"
					              >
					                <path d="M160 0c17.7 0 32 14.3 32 32l0 35.7c1.6 .2 3.1 .4 4.7 .7c.4 .1 .7 .1 1.1 .2l48 8.8c17.4 3.2 28.9 19.9 25.7 37.2s-19.9 28.9-37.2 25.7l-47.5-8.7c-31.3-4.6-58.9-1.5-78.3 6.2s-27.2 18.3-29 28.1c-2 10.7-.5 16.7 1.2 20.4c1.8 3.9 5.5 8.3 12.8 13.2c16.3 10.7 41.3 17.7 73.7 26.3l2.9 .8c28.6 7.6 63.6 16.8 89.6 33.8c14.2 9.3 27.6 21.9 35.9 39.5c8.5 17.9 10.3 37.9 6.4 59.2c-6.9 38-33.1 63.4-65.6 76.7c-13.7 5.6-28.6 9.2-44.4 11l0 33.4c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-34.9c-.4-.1-.9-.1-1.3-.2l-.2 0s0 0 0 0c-24.4-3.8-64.5-14.3-91.5-26.3c-16.1-7.2-23.4-26.1-16.2-42.2s26.1-23.4 42.2-16.2c20.9 9.3 55.3 18.5 75.2 21.6c31.9 4.7 58.2 2 76-5.3c16.9-6.9 24.6-16.9 26.8-28.9c1.9-10.6 .4-16.7-1.3-20.4c-1.9-4-5.6-8.4-13-13.3c-16.4-10.7-41.5-17.7-74-26.3l-2.8-.7s0 0 0 0C119.4 279.3 84.4 270 58.4 253c-14.2-9.3-27.5-22-35.8-39.6c-8.4-17.9-10.1-37.9-6.1-59.2C23.7 116 52.3 91.2 84.8 78.3c13.3-5.3 27.9-8.9 43.2-11L128 32c0-17.7 14.3-32 32-32z"/></svg>
					              <div v-if="room.special_price" class="result ms-3">{{ room.special_price }}</div>
					              <div v-else class="result ms-3">{{ room.price }}</div>
					            </div>

					        </div>

					        <div class="w-100 mb-1">
					            <label> Total Price</label>
					            <div class="search-input d-flex align-items-center ps-2 mb-1">
					              <svg
					                aria-hidden="true"
					                fill="#333333"
					                focusable="false"
					                height="20"
					                role="presentation"
					                width="20"
					                viewBox="0 0 320 512"
					              >
					                <path d="M160 0c17.7 0 32 14.3 32 32l0 35.7c1.6 .2 3.1 .4 4.7 .7c.4 .1 .7 .1 1.1 .2l48 8.8c17.4 3.2 28.9 19.9 25.7 37.2s-19.9 28.9-37.2 25.7l-47.5-8.7c-31.3-4.6-58.9-1.5-78.3 6.2s-27.2 18.3-29 28.1c-2 10.7-.5 16.7 1.2 20.4c1.8 3.9 5.5 8.3 12.8 13.2c16.3 10.7 41.3 17.7 73.7 26.3l2.9 .8c28.6 7.6 63.6 16.8 89.6 33.8c14.2 9.3 27.6 21.9 35.9 39.5c8.5 17.9 10.3 37.9 6.4 59.2c-6.9 38-33.1 63.4-65.6 76.7c-13.7 5.6-28.6 9.2-44.4 11l0 33.4c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-34.9c-.4-.1-.9-.1-1.3-.2l-.2 0s0 0 0 0c-24.4-3.8-64.5-14.3-91.5-26.3c-16.1-7.2-23.4-26.1-16.2-42.2s26.1-23.4 42.2-16.2c20.9 9.3 55.3 18.5 75.2 21.6c31.9 4.7 58.2 2 76-5.3c16.9-6.9 24.6-16.9 26.8-28.9c1.9-10.6 .4-16.7-1.3-20.4c-1.9-4-5.6-8.4-13-13.3c-16.4-10.7-41.5-17.7-74-26.3l-2.8-.7s0 0 0 0C119.4 279.3 84.4 270 58.4 253c-14.2-9.3-27.5-22-35.8-39.6c-8.4-17.9-10.1-37.9-6.1-59.2C23.7 116 52.3 91.2 84.8 78.3c13.3-5.3 27.9-8.9 43.2-11L128 32c0-17.7 14.3-32 32-32z"/></svg>
					              <div class="result ms-3">{{ guestData.price }}</div>
					            </div>

					        </div>

					        <button v-if="room.booked === 0" class="search-btn">
			                	
			                	<Link :href="route('reservation')" style="color: white;">
			                    	<button>Booking</button>
			                    </Link>
			                </button>
		                    

			                <div v-else class="w-100 mb-2">
			                	<p> This room already Booked</p>
			                	<Link :href="route('main')" class="error-button">
							        <button>Go Back Home</button>
							    </Link>
			                </div>
				        </div>

				        <div v-else class="search-area">
				        	<div v-if="room.booked === 0" class="w-100 mb-2">
				        		<p> For Booking Go to Home Page and search room</p>
					        	<Link :href="route('main')" class="search-btn">
			                    	Booking
			                    </Link>
				        	</div>
				        	<div v-else class="w-100 mb-2">
			                	<p> This room already Booked</p>
			                	<Link :href="route('main')" class="error-button">
							        <button>Go Back Home</button>
							    </Link>
			                </div>
				        </div>
                    </div>
                    <!-- Booking End -->

                    <!-- Category Start -->
                    <div class="bg-light p-4 mb-5 wow fadeInUp" data-wow-delay="0.1s">
                        <h4 class="section-title text-start mb-4">Category</h4>
                        <div class="d-block position-relative mb-3" >
                            <img class="img-fluid" :src="categoryImage" alt="">
                            <div class="d-flex position-absolute top-0 start-0 w-100 h-100 p-3" style="background: rgba(0,0,0,.3);">
                                <h5 class="text-white m-0 mt-auto">{{room.category.name}}</h5>
                            </div>
                        </div>
                    </div>
                    <!-- Category End -->
    
                </div>
                <!-- Sidebar End -->
            </div>
        </div>
    </div>
</template>
  
<script>
  	import "@/css/room.css";
  	import "@/css/bootstrap.min.css";
  	import ImageSlider from "@/Components/ImageSlider.vue";
  	import Navbar from "@/Components/Layout.vue";
  	import categoryImage from '@/assets/img/cat-1.jpg';
  	import { Link, router } from '@inertiajs/vue3';

	export default {
	    name: "RoomDetails",

	    props: {
		    room: {
		        type: Object,
		        required: true,
		    },
		    guestData: {
		        type: Object,
		        required: false, 
		    },
		    roomDescription: {
		      type: String,
		      required: true,
		    },
	    },
	    data() {
	    	
	      	return {
		        categoryImage,
		        activeTab: "overview",
		    };
	    },
	    methods: {
            submitForm() {
			    console.log(this.formData);
			    
			}
        },
	    components: {
	    	ImageSlider, Navbar, Link
	    },
	    computed: {
	      	parsedTags (){
                try {
                    return JSON.parse(this.room.tags);
                } catch (error) {
                    console.error('Error parsing tags:', error);
                    return [];
                }
            },
		    overviewContent() {
		      return this.room.description;
		    },
		    
		    computedPricingDetails() {
		      const basePrice = (this.room.special_price) ? this.room.special_price : this.room.price;
		      return [
		        { label: "Nightly", price: basePrice * 1 },
		        { label: "Weekly", price: basePrice * 7 },
		        { label: "Monthly", price: basePrice * 30 },
		      ];
		    },

		    transformedImages() {
		    	return this.room.images.map((img) => `/storage/${img.image_path.replace(' ', '')}`)
		    }

	    },
	    
	};
</script>
  
<style scoped>
  .search-area {
    top: 120px;
    background-color: #fcbb01;
    width: 100%;
    height: 100%;
    padding: 20px 20px;
    border-radius: 3px;
  }
  .search-input {
    height: 36px;
    background-color: white;
    border-radius: 2px;
  }
  	.search-btn {

	    width: 200px;
	    padding: 10px 20px;
	    background-color: #1471c2;
	    color: white;
	    border: none;
	    border-radius: 5px;
	    outline: none;
	    cursor: pointer;
	    transition: background-color 0.3s ease;
	  }
  	.badge {
      background-color: #007bff;
      color: #fff;
      padding: 0.25em 0.5em;
      border-radius: 0.25rem;
      margin-right: 0.2em;
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
</style>