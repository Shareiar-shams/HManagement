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
                Reserve Restaurent
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
                                  <th class="px-4 py-2">Name</th>
                                  <th class="px-4 py-2">Email</th>
                                  <th class="px-4 py-2">Phone</th>
                                  <th class="px-4 py-2">Booking Time</th>
                                  <th class="px-4 py-2">Number Of Guest</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-if="reserveRestaurent == null"
                                  v-for="(item, index) in reserveRestaurent"
                                  :key="item.id"
                                  class="bg-white border-b hover:bg-blue-50 transition-colors"
                                >
                                  <td class="px-4 py-2 text-center">{{ index + 1 }}</td>
                                  <td class="px-4 py-2 text-center">{{ item.name.name }}</td>
                                  <td class="px-4 py-2 text-center">{{ item.email }}</td>
                                  <td class="px-4 py-2 text-center">{{ item.phone }}</td>
                                  <td class="px-4 py-2 text-center">{{ item.booking_time }}</td>
                                  <td class="px-4 py-2 text-center">{{ item.number_of_guests }}</td>
                                </tr>
                                <tr v-else>
                                	<td class="mx-auto" colspan="6" rowspan="6" headers=""><p>No data found</p></td>
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
            reserveRestaurent:{
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
