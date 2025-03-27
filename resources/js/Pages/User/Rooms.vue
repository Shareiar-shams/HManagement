<template>
    <Navbar />
    <main class="home">
    	<Room v-if="rooms && rooms.length > 0" :rooms="rooms"/>
	    <Services />
    </main>
</template>

<script setup>
    import Navbar from "@/Components/Layout.vue";
    import Room from "@/Components/Room.vue";
    import Services from "@/Components/Services.vue";

    const props = defineProps({
	    rooms: {
	        type: Array,
	        required: true,
	    },
    });
</script>

<style scoped>
	.home {
	    min-height: 100vh;
	    padding: 10px 60px 30px 60px;
	    background-color: #f5f5f5;
	    color: rgb(51, 51, 51);
	}
</style>