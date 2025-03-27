<template>
    <div class="container-xxl py-5">
      <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
          <h6 class="section-title text-center text-primary text-uppercase">Our Services</h6>
          <h1 class="mb-5">Explore Our <span class="text-primary text-uppercase">Services</span></h1>
        </div>
        <div class="row g-4">
          <div v-for="(service, index) in services" :key="index" class="col-lg-4 col-md-6 wow fadeInUp" :data-wow-delay="`${0.1 + index * 0.1}s`">
            <Link class="service-item rounded" :href="service.link">
              <div class="service-icon bg-transparent border rounded p-1">
                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                    <font-awesome-icon :icon="service.iconClass" size="2x" spin/>
                </div>
              </div>
              <h5 class="mb-3">{{ service.title }}</h5>
              <p class="text-body mb-0">{{ service.description }}</p>
            </Link>
          </div>
        </div>
      </div>
    </div>
  </template>
  
<script>
    import "@/css/room.css";
    import "@/css/bootstrap.min.css";
    import { library } from '@fortawesome/fontawesome-svg-core';
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
    import { Link } from '@inertiajs/vue3';
    import { faHotel, faUtensils, faGlassCheers } from '@fortawesome/free-solid-svg-icons'; // Import specific icons

    // Add the icons to the library
    library.add(faHotel, faUtensils, faGlassCheers);

    export default {
        name: 'ServicesSection',
        components: {
            FontAwesomeIcon, Link
        },
        data() {
          return {
            services: [
              {
                title: 'Rooms & Apartment',
                description: 'Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed stet lorem.',
                iconClass: ['fas', 'hotel'],
                link: route('rooms'),
              },
              {
                title: 'Food & Restaurant',
                description: 'Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed stet lorem.',
                iconClass: ['fas', 'utensils'],
                link: route('restaurent'),
              },
              {
                title: 'Event & Party',
                description: 'Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed stet lorem.',
                iconClass: ['fas', 'glass-cheers'],
                link: '#'
              }
            ]
          };
        }
    };
</script>
  
<style scoped>
  /* Add any specific styles for your component here */
</style>