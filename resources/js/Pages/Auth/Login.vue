<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Layout from '@/Components/Layout.vue';
import "@/css/style.css";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
<!-- 
<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 block">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600"
                        >Remember me</span
                    >
                </label>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Forgot your password?
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template> -->

<template>
    <Layout />
    <Head title="Log in" />

    <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
        {{ status }}
    </div>
    <div class="main">
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <form @submit.prevent="submit">
                        <h2 class="form-title">Log in</h2>
                        <div class="form-group">

                            <TextInput
                                id="email"
                                type="email"
                                class="form-input"
                                v-model="form.email"
                                required
                                autofocus
                                placeholder="Email"
                                autocomplete="username"
                            />

                            <InputError class="mt-2" :message="form.errors.email" />

                        </div>


                        <div class="form-group">

                            <TextInput
                                id="password"
                                type="password"
                                class="form-input"
                                v-model="form.password"
                                required
                                placeholder="Password"
                                autocomplete="current-password"
                            />

                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>

                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>
                    

                        <div class="form-group mt-4 flex items-center justify-between">

                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            >
                                Forgot your password?
                            </Link>

                            <div class="flex items-center">
                                <Checkbox id="agree-term" class="agree-term" name="remember" v-model:checked="form.remember" />
                            
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>Remember me</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" id="submit" class="form-submit" > Log in </button>
                        </div>


                    </form>
                    <p class="loginhere">

                        Haven't any account ? 
                        <Link
                            :href="route('register')"
                            class="loginhere-link"
                        >
                            Sign Up Here
                        </Link>
                    </p>
                  
                </div>
            </div>
        </section>
    </div>
</template>
<style>

</style>
