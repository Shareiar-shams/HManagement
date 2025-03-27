<template>
    <main class="main" ref="content">
      <!-- Modal to show payment status -->
      <div
        v-if="isModalOpen"
        class="
          payment-verification
          d-flex
          flex-column
          justify-content-evenly
          align-items-center
        "
      >
        <div v-if="!success" class="spinner-border text-primary" role="status">
          <span class="sr-only">Loading...</span>
        </div>
        <div v-if="!success">Waiting For Payment Verification</div>
        <div
          v-if="success"
          class="d-flex flex-column justify-content-evenly align-items-center"
        >
          <div>
            <i
              style="color: green; font-size: 40px"
              class="fa fa-check-square-o mb-4"
              aria-hidden="true"
            ></i>
          </div>
          <div>Payment is successful</div>
        </div>
      </div>
  
      <!--When modal is closed, this area shows the booking and guests details-->
      <div v-if="!isModalOpen" class="booking-details">
        <!-- Button for downloading booking and guests detail as PDF (html2pdf.js)-->
        <button class="mb-3" @click="download">
          Download Your Booking Details
        </button>
        <!--Booking confirmation details with hotel and guest info-->
        <h1 class="h3">Booking Confirmation Details</h1>
        <div class="hotel-details mb-3">
          <p class="m-0 mb-1">Room: {{ selectedHotel.name }}</p>
          <p class="m-0 mb-1">Check-in Date: {{ guestData.checkinDate }}</p>
          <p class="m-0 mb-1">Check-out Date: {{ guestData.checkoutDate }}</p>
          <p class="m-0 mb-1">
            Guests: {{ guestData.adult }} Adult(s)
            <span v-if="guestData.children !== 0"
              >, {{ guestData.children }} Children</span
            >
          </p>
          <p class="m-0 mb-1">Days: {{ guestData.days }} Room(s)</p>
          <p class="m-0 mb-1">Total Price: &#2547; {{ guestData.total_amount }}</p>
          <p class="m-0 mb-1">Transection Id: {{ guestData.tran_id }}</p>
          <p v-if="guestData.bank_tran_id" class="m-0 mb-1">Bank Transection Id:  {{ guestData.bank_tran_id }}</p>
          <p v-if="guestData.payment_gateway_type" class="m-0 mb-1">Card Type: {{ guestData.payment_gateway_type }}</p>
          <p v-if="guestData.card_brand" class="m-0 mb-1">Card Brand: {{ guestData.card_brand }}</p>
        </div>
        <div class="guest-details d-flex gap-5 mb-4">
          <div class="guest">
            <h2 class="h5">Customer Details</h2>
            <p class="m-0 mb-1">Name: {{ allGuestInfo.name }}</p>
            <p class="m-0 mb-1">Identitiy No.: {{ allGuestInfo.identification }}</p>
            <p class="m-0 mb-1">
              <span class="me-4">Sex: {{ allGuestInfo.sex }}</span>
            </p>
            <p class="m-0 mb-1">E-mail: {{ allGuestInfo.email }}</p>
            <p class="m-0 mb-1">Phone: {{ allGuestInfo.phone }}</p>
          </div>
        </div>
        <Link :href="route('main')" class="error-button">
            <button>Go Back Home</button>
        </Link>
      </div>
    </main>
</template>
  
<script>
    import html2pdf from "html2pdf.js";
    import { Link, router } from '@inertiajs/vue3';
    export default {
        name: "Reservation",
        data() {
          return {
            isModalOpen: true,
            success: false,
          };
        },
        props: {
          selectedHotel: Object,
          allGuestInfo: Object,
          guestData: Object,
        },
        components: {
          Link
        },
        methods: {
          closeModal() {
            setTimeout(() => (this.isModalOpen = false), 6000);
            setTimeout(() => (this.success = true), 3000);
          },
          download() {
            html2pdf(this.$refs.content);
          },
        },
        computed: {
          
        },
        mounted() {
            this.closeModal();
        },
    };
</script>
  
<style scoped>
    .main {
      display: flex;
      padding: 120px 50px 50px 50px;
      background-color: #f5f5f5;
      min-height: 100vh;
    }
    .payment-verification {
      width: 40vw;
      height: 30vh;
      margin: 0 auto;
      background-color: white;
      border-radius: 10px;
      font-size: 24px;
      font-weight: 600;
    }
    .booking-details {
      width: 100vw;
      min-height: 100vh;
    }
    .guest-details {
      flex-wrap: wrap;
    }
    .guest {
      border: 1px solid rgb(177, 177, 177);
      border-radius: 5px;
      padding: 20px;
    }
    button {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 5px;
      background: #1a4a8d;
      font-size: 16px;
      color: #fff;
      cursor: pointer;
    }
    button:hover {
      background: #14396d;
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