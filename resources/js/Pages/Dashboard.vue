<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Room Reservations
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="content p-6 bg-white rounded-lg shadow-lg max-w-4xl mx-auto">
                          <!-- Search Input -->
                        <input
                            type="text"
                            class="form-control mb-5 w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm"
                            placeholder="🔍 Search..."
                            v-model="searchQuery"
                        />

                        <div class="overflow-x-auto">
                            <table class="table-auto w-full border-collapse rounded-lg shadow-sm">
                              <thead class="bg-blue-600 text-white">
                                <tr>
                                  <th class="px-4 py-2">ID</th>
                                  <th class="px-4 py-2">Room</th>
                                  <th class="px-4 py-2">Floor</th>
                                  <th class="px-4 py-2">Checkin Date</th>
                                  <th class="px-4 py-2">Checkout Date</th>
                                  <th class="px-4 py-2">Total Amount</th>
                                  <th class="px-4 py-2">Transection Id</th>
                                  <th class="px-4 py-2">Payment Status</th>
                                  <th class="px-4 py-2">Booking Status</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-if="booked_room != null" v-for="(item, index) in booked_room"
                                    :key="item.id"
                                    class="bg-white border-b hover:bg-blue-50 transition-colors"
                                    >
                                    <td class="px-4 py-2 text-center">{{ index + 1 }}</td>
                                    <td class="px-4 py-2 text-center">{{ item.room.name }}</td>
                                    <td class="px-4 py-2 text-center">{{ item.floor ?? null }}</td>
                                    <td class="px-4 py-2 text-center">{{ item.checkinDate }}</td>
                                    <td class="px-4 py-2 text-center">{{ item.checkoutDate }}</td>
                                    <td class="px-4 py-2 text-center">{{ item.total }}</td>
                                    <td class="px-4 py-2 text-center">{{ item.tran_id }}</td>
                                    <td class="px-4 py-2 text-center">{{ item.payment_status }}</td>
                                    <td class="px-4 py-2 text-center">{{ item.order_status }}</td>
                                </tr>
                                <tr v-else>
                                    <td class="mx-auto" colspan="6" rowspan="3" headers=""><p>No data found</p></td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
    export default {
        props:{
            booked_room:{
                type: Array,
                required: true,
            }
        },
        data() {
            
        },
        computed: {
            
        },
        methods: {
            
        },
    };
</script>
