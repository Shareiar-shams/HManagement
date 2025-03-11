<template>
    <div class="custom-card mb-3">
        <!-- Room image-->
        <img class="card-img" :src="imageUrl" :alt="`${room.name}-featured-image`" />

        <!--Room details (name,rooms,price)-->
        <div class="w-50 ml-4">
            <h5 class="card-title blue mb-1">
                {{ room.name }}
            </h5>
            
            <p class="card-text mb-2">
                <span v-if="parsedTags && parsedTags.length > 0">
                  <span v-for="(tag, index) in parsedTags" :key="index" class="badge badge-warning">
                    {{ tag }}
                  </span>
                </span>
                <span v-else>
                  
                </span>
            </p>
            <p class="card-text">
                <span class="d-block">{{ room.category.name}}</span>
            </p>
            <p class="card-text green">
                {{ truncatedDescription }}
            </p>
        </div>

        <div class="ms-auto d-flex flex-column">
            <div class="d-flex justify-content-end">
                <div class="d-flex flex-column">
                  <p>SKU: <span class="me-2">{{ room.SKU }}</span></p>
                </div>
            </div>
            <div class="d-flex flex-column align-items-end">
                <small class="ms-auto"
                >{{ guestData.days }} night, {{ guestData.adult }} adults,
                {{ guestData.children }} Child(s)</small
                >
                <p class="my-0 h4">
                    <span v-if="room.special_price">
                        <del><span v-html="'&#2547;'"></span>{{ room.price * guestData.days }}</del>
                        <span class="ms-2"><span v-html="'&#2547;'"></span>{{ room.special_price * guestData.days }}</span>
                    </span>
                    <span v-else>
                        <span v-html="'&#2547;'"></span>{{ room.price * guestData.days }}
                    </span>
                </p>
                <small>+<span v-html="'&#2547;'"></span> {{ tax }} taxes and charges</small>
                
                <Link :href="route('roomDetails', room.slug)" class="book-btn rounded d-block mt-2">
                      See Availability
                </Link>

                <!-- <button @click="goToRoomDetails" class="book-btn rounded d-block mt-2">
                    See Availability
                </button> -->
            </div>
        </div>
    </div>
</template>

<script>
    import { Link, router } from '@inertiajs/vue3';
    export default {
        name: "Card",
        components: {
            Link,
        },
        props: {
            room: Object,
            guestData: Object,
        },
        methods: {
            goToRoomDetails() {
              router.post(route('roomDetails', { slug: this.room.slug }), {
                guestData: this.guestData,  // Pass guestData as POST data
              });
            },
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
            //Calculating 18% tax for room price
            tax() {
                const price = this.room.special_price ? this.room.special_price : this.room.price;
                return (price * this.guestData.days * 18) / 100;
                
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
    };
</script>

<style scoped>
    .custom-card {
    display: flex;
    padding: 10px;
    border: 1px solid rgb(187, 187, 187);
    border-radius: 5px;
    }
    .card-img {
    max-height: 200px;
    max-width: 200px;
    }
    .card-title {
    font-size: 20px;
    font-weight: 700;
    }
    .card-text {
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    }
    .blue {
    color: rgb(0, 113, 194);
    }
    .green {
        width: 80%;
    color: rgb(0, 128, 9);
    font-weight: 700;
    }
    .book-btn {
    text-decoration: none;
    color: white;
    padding: 10px 20px;
    background-color: rgb(0, 113, 194);
    text-align: center;
    }

    .book-btn:hover {
    background-color: #043580;
    }

    .rating {
    font-size: 16px;
    font-weight: 500;
    width: 32px;
    height: 32px;
    background-color: #043580;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px 5px 5px 0;
    }
    .badge {
      background-color: #007bff;
      color: #fff;
      padding: 0.25em 0.5em;
      border-radius: 0.25rem;
      margin-right: 0.2em;
    }

    small {
    font-size: 12px;
    font-weight: 400;
    color: rgb(107, 107, 107);
    }
</style>