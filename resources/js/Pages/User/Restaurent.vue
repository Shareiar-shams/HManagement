<template>
	<Navbar />
	<div class="max-w-xl mx-auto p-6 bg-white rounded-2xl shadow-xl mt-10">
	    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Book a Table</h2>
	    <form @submit.prevent="submitBooking" class="space-y-5">
	        <div>
	            <label class="block text-gray-600 mb-1">Name:</label>
	            <input
	                v-model.trim="form.name"
	                id="name"
	                type="text"
	                placeholder="Enter your name"
	                class="w-full border rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500
	                       transition duration-200 ease-in-out :class='{ 'border-red-500': v$.name.$error }'"
	            />
	            <div v-if="v$.name.$error" class="text-red-500 text-sm mt-1">
	                <div v-if="!v$.name.required">Name is required.</div>
	                <div v-if="!v$.name.error">Name must be at least 3 characters.</div>
	            </div>
	        </div>
	        
	        <div>
	            <label class="block text-gray-600 mb-1">Email:</label>
	            <input
	                v-model.trim="form.email"
	                id="email"
	                type="email"
	                placeholder="Enter your email"
	                class="w-full border rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500
	                       transition duration-200 ease-in-out :class='{ 'border-red-500': v$.email.$error }'"
	            />
	            <div v-if="v$.email.$error" class="text-red-500 text-sm mt-1">
	                <div v-if="!v$.email.required">Email is required.</div>
	                <div v-if="!v$.email.error">Enter a valid email address.</div>
	            </div>
	        </div>
	        
	        <div>
	            <label class="block text-gray-600 mb-1">Phone:</label>
	            <input
	                v-model.trim="form.phone"
	                id="phone"
	                type="text"
	                placeholder="Enter your phone Number (e.g 017*********)"
	                class="w-full border rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500
	                       transition duration-200 ease-in-out :class='{ 'border-red-500': v$.phone.$error }'"
	            />
	            <div v-if="v$.phone.$error" class="text-red-500 text-sm mt-1">
	                <div v-if="!v$.phone.required">Phone is required.</div>
	                <div v-if="!v$.phone.error">Enter a valid Bangladeshi phone number starting with 01.</div>
	            </div>
	        </div>
	        
	        <div>
	            <label class="block text-gray-600 mb-1">Booking Time:</label>
	            <input
	                v-model.trim="form.booking_time"
	                id="booking_time"
	                type="datetime-local"
	                class="w-full border rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500
	                       transition duration-200 ease-in-out :class='{ 'border-red-500': v$.booking_time.$error }'"
	            />
	            <div v-if="v$.booking_time.$error" class="text-red-500 text-sm mt-1">
	                Booking Time is required.
	            </div>
	        </div>
	        
	        <div>
	            <label class="block text-gray-600 mb-1">Number of Guests:</label>
	            <input
	                v-model.trim="form.number_of_guests"
	                id="number_of_guests"
	                type="number"
	                placeholder="Enter number of guests"
	                class="w-full border rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500
	                       transition duration-200 ease-in-out :class='{ 'border-red-500': v$.number_of_guests.$error }'"
	            />
	            <div v-if="v$.number_of_guests.$error" class="text-red-500 text-sm mt-1">
	                Please enter the number of guests.
	            </div>
	        </div>
	        
	        <button type="submit"
	            class="w-full bg-blue-600 text-white rounded-lg py-2 mt-4 hover:bg-blue-700 transition duration-200">
	            Book Now
	        </button>
	    </form>
	</div>

</template>

<script setup>
    import Navbar from "@/Components/Layout.vue";
    import { useForm } from '@inertiajs/vue3';
    import useVuelidate from '@vuelidate/core';
    import { required, minLength, email, helpers } from '@vuelidate/validators';
    import Swal from 'sweetalert2';

    const phoneCheck = (val) => /^(018|013|014|015|016|017|019)\d{8}$/.test(val);

    const form = useForm({
	    name: '',
        email: '',
        phone: '',
        booking_time: '',
        number_of_guests: 1,
    });

    // Validation rules for form fields
    const rules = {
        name: { required, minLength: minLength(3) },
        email: { required, email },
        phone: { required, phoneCheck },
        booking_time: { required },
        number_of_guests: { required }
        
    };
    const v$ = useVuelidate(rules, form);

    const submitBooking = () => {
    	v$.value.$touch(); 
        if (!v$.value.$invalid) {

	      	form.post(route('restaurent_booking'), {
	          	onFinish: () => {
	                form.reset();  // Reset the form

	                // Show SweetAlert success message
	                Swal.fire({
	                    title: 'Booking Successful!',
	                    text: 'Your table has been booked successfully.',
	                    icon: 'success',
	                    confirmButtonText: 'OK'
	                });
	            },
	            onError: () => {
	                // Show SweetAlert error message if needed
	                Swal.fire({
	                    title: 'Booking Failed!',
	                    text: 'There was a problem with your booking. Please try again.',
	                    icon: 'error',
	                    confirmButtonText: 'OK'
	                });
	            }
	      	});
	    }
    };

</script>

<style scoped>
/* Add your styles here */
</style>