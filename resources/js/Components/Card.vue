<template>
    <div class="custom-card">
        <!-- Room Image -->
        <div class="image-container">
            <img class="card-img" :src="imageUrl" :alt="`${room.name}-featured-image`" />
        </div>

        <!-- Room Details -->
        <div class="details">
            <h5 class="card-title">
                {{ room.name }}
            </h5>

            <p class="tags">
                <span v-if="parsedTags.length">
                  <span v-for="(tag, index) in parsedTags" :key="index" class="badge">
                    {{ tag }}
                  </span>
                </span>
            </p>

            <p class="category">{{ room.category.name }}</p>

            <p class="description">
                {{ truncatedDescription }}
            </p>

            <!-- Price & Availability -->
            <div class="price-info">
                <small>{{ guestData.days }} night(s), {{ guestData.adult }} adult(s), {{ guestData.children }} child(ren)</small>
                
                <p class="price">
                    <span v-if="room.special_price">
                        <del class="old-price"><span v-html="'&#2547;'"></span>{{ room.price * guestData.days }}</del>
                        <span class="new-price"><span v-html="'&#2547;'"></span>{{ room.special_price * guestData.days }}</span>
                    </span>
                    <span v-else>
                        <span v-html="'&#2547;'"></span>{{ room.price * guestData.days }}
                    </span>
                </p>
            </div>

            <!-- Buttons -->
            <Link :href="route('roomDetails', room.slug)" class="book-btn">
                See Availability
            </Link>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
    name: "Card",
    components: { Link },
    props: {
        room: Object,
        guestData: Object,
    },
    computed: {
        truncatedDescription() {
            if (!this.room.short_description) return '';
            const words = this.room.short_description.split(' ');
            return words.length > 25 ? words.slice(0, 25).join(' ') + '...' : this.room.short_description;
        },
        imageUrl() {
            if (this.room.featured_image?.startsWith('https')) {
                return this.room.featured_image;
            } else {
                return `/storage/${this.room.featured_image.replace(' ', '')}`;
            }
        },
        parsedTags() {
            try {
                return JSON.parse(this.room.tags) || [];
            } catch (error) {
                return [];
            }
        },
    },
};
</script>

<style scoped>
    /* Card Container */
    .custom-card {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 15px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out;
    }

    .custom-card:hover {
        transform: translateY(-5px);
    }

    /* Image */
    .image-container {
        flex: 1;
        max-width: 200px;
    }

    .card-img {
        width: 100%;
        border-radius: 8px;
        object-fit: cover;
    }

    /* Details */
    .details {
        flex: 2;
        min-width: 250px;
    }

    .card-title {
        font-size: 20px;
        font-weight: bold;
        color: #0073e6;
        margin-bottom: 5px;
    }

    .tags {
        margin-bottom: 5px;
    }

    .badge {
        background-color: #007bff;
        color: white;
        padding: 5px 8px;
        font-size: 12px;
        border-radius: 4px;
        margin-right: 5px;
    }

    /* Category & Description */
    .category {
        font-size: 14px;
        color: #666;
    }

    .description {
        font-size: 14px;
        color: #333;
        font-weight: 500;
    }

    /* Pricing */
    .price-info {
        margin-top: 10px;
    }

    .price {
        font-size: 18px;
        font-weight: bold;
    }

    .old-price {
        color: #888;
        text-decoration: line-through;
        margin-right: 8px;
    }

    .new-price {
        color: #d9534f;
    }

    /* Button */
    .book-btn {
        display: inline-block;
        text-decoration: none;
        background-color: #0073e6;
        color: white;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: bold;
        border-radius: 5px;
        margin-top: 10px;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    .book-btn:hover {
        background-color: #005bb5;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .custom-card {
            flex-direction: column;
            text-align: center;
        }

        .image-container {
            max-width: 100%;
        }

        .details {
            width: 100%;
        }

        .book-btn {
            width: 100%;
        }
    }
</style>
