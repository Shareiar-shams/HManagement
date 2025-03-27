<template>
  <div>
    <form @submit.prevent="submitForm">
      <div>
        <label for="name">Name</label>
        <input type="text" v-model="form.name" id="name" />
        <div v-if="!v$.name.$pending && v$.name.$error">
          <span v-if="!v$.name.required">Name is required.</span>
          <span v-if="!v$.name.error">Name must be at least 3 characters.</span>
        </div>
      </div>

      <button type="submit">Submit</button>
    </form>
  </div>
</template>

<script setup>
import { reactive } from 'vue';
import useVuelidate from '@vuelidate/core';
import { required, minLength, email } from '@vuelidate/validators';

const form = reactive({
  name: '',
});

console.log('minLength:', minLength);
console.log('email:', email);

const rules = {
  name: { required, minLength: minLength(3) },
};

const v$ = useVuelidate(rules, form);

const submitForm = () => {
      v$.value.$touch(); // Trigger validatio
      if (!v$.value.$invalid) {
        alert('Form submitted successfully!');
      }
};
</script>
