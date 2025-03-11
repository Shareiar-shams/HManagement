<template>
    <div class="col-lg-4 col-md-6 wow fadeInUp" :data-wow-delay="`${delay}s`">
      <div class="room-item shadow rounded overflow-hidden">
        <div class="position-relative">
          <img class="img-fluid" :src="imageUrl" :alt="`${room.name}-featured-image`">
          <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">{{ room.price }}</small>
        </div>
        <div class="p-4 mt-2">
          <div class="d-flex justify-content-between mb-3">
            <h5 class="mb-0">{{ room.name }}</h5>
            <div class="ps-2">
              <small class="fa fa-star text-primary">
                <span>SKU:</span>{{ room.SKU }}
              </small>
            </div>
          </div>
          <div class="d-flex mb-3">
              <span v-if="parsedTags && parsedTags.length > 0">
                  <small v-for="(tag, index) in parsedTags" :key="index" class="border-end me-3 pe-3">
                    <span class="badge badge-warning"> {{ tag }} </span>
                    
                  </small>
              </span>
              <span v-else>
                
              </span>
          </div>
          <p class="text-body mb-3">{{ truncatedDescription }}</p>
          <div class="d-flex justify-content-between">
            
              <Link :href="route('roomDetails', room.slug)" class="btn btn-sm btn-primary rounded py-2 px-4">
                View Detail
              </Link>
            <!-- <a class="btn btn-sm btn-dark rounded py-2 px-4" href="">Book Now</a> -->
          </div>
        </div>
      </div>
    </div>
  </template>
  
<script>
  import { Link } from '@inertiajs/vue3';

  export default {
      components: {
          Link
      },
      props: {
        room: {
          type: Object,
          required: true
        },
        delay: {
          type: Number,
          required: true
        }
      },
      computed: {
          truncatedDescription(){
            if (!this.room.short_description) {
                return '';
              }
              const words = this.room.short_description.split(' ');
              if (words.length > 25) {
                return words.slice(0, 25).join(' ') + '...';
              } else {
                return this.room.short_description;
              }
          },
          imageUrl() {

              if (this.room.featured_image && this.room.featured_image.startsWith('https')) {

                  return this.room.featured_image;

              } else if (this.room.featured_image.startsWith('public/')) {

                  return `/storage/${this.room.featured_image.replace('public/', '')}`;
              } else {
                  return `/storage/${this.room.featured_image}`;
              }
              return '';
          },
          parsedTags (){
              try {
                  return JSON.parse(this.room.tags);
              } catch (error) {
                  console.error('Error parsing tags:', error);
                  return []; // Return an empty array in case of an error
              }
          },
      },
  }
  </script>
  
<style scoped>
    .img-fluid{
        width: 100%;
        height: 200px;
    }
    .badge {
      background-color: #007bff;
      color: #fff;
      padding: 0.25em 0.5em;
      border-radius: 0.25rem;
      margin-right: 0.2em;
    }
</style>