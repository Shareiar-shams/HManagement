<template>
    <Navbar />
    <div class="mx-auto bg-white p-6 rounded-lg shadow-md">
      <h2 class="text-2xl font-semibold mb-4">Book Your Room</h2>
      <form @submit.prevent="submitForm">
        <!-- Name Field -->
        <div class="mb-4">
          <label for="name" class="block text-gray-700">Name<span class="text-red-500">*</span></label>
          <input
            v-model.trim="form.name"
            id="name"
            type="text"
            placeholder="Enter your name"

            class="w-full border rounded px-3 py-2"
            :class="{ 'border-red-500': v$.name.$error }"
          />
          <div v-if="v$.name.$error" class="text-red-500 text-sm">
            <div v-if="!v$.name.required">Name is required.</div>
            <div v-if="!v$.name.error">Name must be at least 3 characters.</div>
          </div>
        </div>

        <!-- Email Field -->
        <div class="mb-4">
          <label for="email" class="block text-gray-700">Email<span class="text-red-500">*</span></label>
          <input
            v-model.trim="form.email"
            id="email"
            type="email"
            placeholder="Enter your email"
            
            class="w-full border rounded px-3 py-2"
            :class="{ 'border-red-500': v$.email.$error }"
          />
          <div v-if="v$.email.$error" class="text-red-500 text-sm">
            <div v-if="!v$.email.required">Email is required.</div>
            <div v-if="!v$.email.error">Enter a valid email address.</div>
          </div>
        </div>

        <!-- Phone Field -->
        <div class="mb-4">
          <label for="phone" class="block text-gray-700">Phone<span class="text-red-500">*</span></label>
          <input
            v-model.trim="form.phone"
            id="phone"
            type="text"
            placeholder="Enter your phone Number (e.g 017*********)"
            
            class="w-full border rounded px-3 py-2"
            :class="{ 'border-red-500': v$.phone.$error }"
          />
          <div v-if="v$.phone.$error" class="text-red-500 text-sm">
            <div v-if="!v$.phone.required">Phone is required.</div>
            <div v-if="!v$.phone.error">Enter a valid Bangladeshi phone number star with 01.</div>
          </div>
        </div>

        <!-- Identification Field -->
        <div class="mb-4">
          <label for="identification" class="block text-gray-700">Identification No. (NID)<span class="text-red-500">*</span></label>
          <input
            v-model.trim="form.identification"
            id="identification"
            type="text"
            placeholder="Enter your ID number"
            
            class="w-full border rounded px-3 py-2"
            :class="{ 'border-red-500': v$.identification.$error }"
          />
          <div v-if="v$.identification.$error" class="text-red-500 text-sm">
            Identification is required.
          </div>
        </div>

        <!-- Sex Field -->
        <div class="mb-4">
          <label class="block text-gray-700">Sex<span class="text-red-500">*</span></label>
          <select
            v-model.trim="form.sex"
            class="w-full border rounded px-3 py-2"
            
            :class="{ 'border-red-500': v$.sex.$error }"
          >
            <option value="" disabled>Select your sex</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
          </select>
          <div v-if="v$.sex.$error" class="text-red-500 text-sm">
            Please select your sex.
          </div>
        </div>
        <div class="md-4">
            <div class="flex space-x-4"> <div class="flex-1"> <label class="block text-gray-700">Address<span class="text-red-500">*</span></label>
                <input
                  v-model.trim="form.address"
                  id="address"
                  type="text"
                  placeholder="Enter your address"
                  class="w-full border rounded px-3 py-2"
                  :class="{ 'border-red-500': v$.address.$error }"
                />
                <div v-if="v$.address.$error" class="text-red-500 text-sm">
                  Address is required.
                </div>
              </div>

              <div class="flex-1"> <label class="block text-gray-700">City<span class="text-red-500">*</span></label>
                <input
                  v-model.trim="form.city"
                  id="city"
                  type="text"
                  placeholder="Enter your city"
                  class="w-full border rounded px-3 py-2"
                  :class="{ 'border-red-500': v$.city.$error }"
                />
                <div v-if="v$.city.$error" class="text-red-500 text-sm">
                  City is required.
                </div>
              </div>

              <div class="flex-1"> <label class="block text-gray-700">Postcode<span class="text-red-500">*</span></label>
                <input
                  v-model.trim="form.postcode"
                  id="postcode"
                  type="text"
                  placeholder="Enter your postcode"
                  class="w-full border rounded px-3 py-2"
                  :class="{ 'border-red-500': v$.postcode.$error }"
                />
                <div v-if="v$.postcode.$error" class="text-red-500 text-sm">
                  Postcode is required.
                </div>
              </div>
            </div>
        </div>
        <!-- Payment Method Field -->
        <div class="mb-6 mt-4">
          <label class="block text-gray-700 mb-2">Payment Method<span class="text-red-500">*</span></label>
          <div class="flex gap-4">
            <label class="flex items-center">
              <input
                type="radio"
                value="cash"
                v-model="form.paymentMethod"
                class="mr-2"
              />
              Cash
            </label>
            <label class="flex items-center">
              <input
                type="radio"
                value="sslcommerz"
                v-model="form.paymentMethod"
                class="mr-2"
              />
              Online Banking (SSLCommerz)
            </label>
          </div>
          <div v-if="v$.paymentMethod.$error" class="text-red-500 text-sm">
            Please select a payment method.
          </div>
        </div>

        <!-- SSLCommerz Fields (only if selected) -->
        <!-- <div v-if="form.paymentMethod === 'sslcommerz'" class="mb-6">
          <label class="block text-gray-700 mb-2">SSLCommerz Information</label>
          <input
            v-model.trim="form.sslEmail"
            type="email"
            placeholder="Enter email for payment"
            class="w-full border rounded px-3 py-2 mb-2"
            :class="{ 'border-red-500': v$.sslEmail.$error }"
          />
          <div v-if="v$.sslEmail.$error" class="text-red-500 text-sm mb-2">
            <div v-if="!v$.sslEmail.required">Email is required for SSLCommerz.</div>
            <div v-if="!v$.sslEmail.error">Enter a valid email address.</div>
          </div>

          <input
            v-model.trim="form.sslPhone"
            type="text"
            placeholder="Enter phone number for payment"
            class="w-full border rounded px-3 py-2"
            :class="{ 'border-red-500': v$.sslPhone.$error }"
          />
          <div v-if="v$.sslPhone.$error" class="text-red-500 text-sm">
            <div v-if="!v$.sslPhone.required">Phone number is required for SSLCommerz.</div>
            <div v-if="!v$.sslPhone.error">Enter a valid Bangladeshi phone number.</div>
          </div>
        </div> -->

        <!-- Submit Button -->
        <button
          type="submit"
          class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition"
        >
          Submit
        </button>
      </form>
    </div>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import useVuelidate from '@vuelidate/core';
    import { required, minLength, email, helpers } from '@vuelidate/validators';
    import Navbar from "@/Components/Layout.vue";
    import { defineProps } from 'vue';

    // Define props to get data from parent component (selectedHotel, guestData)
    const props = defineProps({
        selectedHotel: Object, 
        guestData: Object,
    });

    const phoneCheck = (val) => /^(018|013|014|015|016|017|019)\d{8}$/.test(val);
    function generateTranId(length = 20) {
        let result = 'tran_';
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        const charactersLength = characters.length;
        for (let i = 0; i < length; i++) {
          result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }
    // Form state using Inertia's useForm
    const form = useForm({
        name: '',
        email: '',
        phone: '',
        identification: '',
        sex: '',
        address: '',
        city: '',
        postcode: '',
        paymentMethod: '', 
        guestData: props.guestData,
        selectedHotel: props.selectedHotel
    });

    // Validation rules for form fields
    const rules = {
        name: { required, minLength: minLength(3) },
        email: { required, email },
        phone: { required, phoneCheck },
        identification: { required },
        sex: { required },
        address: { required },
        city: { required },
        postcode: { required },
        paymentMethod: { required },
        
    };
    const v$ = useVuelidate(rules, form);
    const submitForm = () => {
        v$.value.$touch(); 
        if (!v$.value.$invalid) {
            if (form.paymentMethod === 'sslcommerz') {

              const paymentData = {
                  total_amount: props.guestData.price,
                  currency: 'BDT',
                  tran_id: generateTranId(8),
                  customer_name: form.name,
                  customer_email: form.email,
                  customer_phone: form.phone,
                  customer_identification: form.identification,
                  customer_sex: form.sex,
                  customer_address: form.address,
                  customer_city: form.city,
                  customer_postcode: form.postcode,
                  selectedHotel: props.selectedHotel, // Include selectedHotel
                  guestData: props.guestData
              };

              axios.post('/sslcommerz/initiate', paymentData)
              .then(response => {
                if (response.data && response.data.GatewayPageURL) {
                    window.location.href = response.data.GatewayPageURL;
                } else {
                    // console.error('Failed to get payment URL.');
                    alert('Failed to get payment URL.');
                }
              })
              .catch(error => alert('SSLCommerz Error:', error));
            } else {
              // Submit form normally for Cash
              form.post(route('payment'), {
                  onFinish: () => form.reset(),
              });
            }
        }
    };
</script>

<style scoped>
    .border-red-500 {
      border-color: #f87171;
    }

    input[type="radio"] { accent-color: #2563eb; }
</style>
