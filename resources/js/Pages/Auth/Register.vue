<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Layout from '@/Components/Layout.vue';
import "@/css/style.css";

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<!-- <template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
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
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Already registered?
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
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
    <div class="main-signup">
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <form @submit.prevent="submit">
                        <h2 class="form-title">Create account</h2>
                        <div class="form-group">

                            <TextInput
                                id="name"
                                type="text"
                                class="form-input"
                                v-model="form.name"
                                required
                                autofocus
                                placeholder="Name"
                                autocomplete="username"
                            />

                            <InputError class="mt-2" :message="form.errors.name" />

                        </div>

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

                        <div class="mt-4">
                            <TextInput
                                id="password"
                                type="password"
                                class="form-input"
                                v-model="form.password"
                                required
                                placeholder="Password"
                                autocomplete="new-password"
                            />

                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="mt-4">
                            
                            <TextInput
                                id="password_confirmation"
                                type="password"
                                class="form-input"
                                v-model="form.password_confirmation"
                                required
                                placeholder="Repeat your password"
                                autocomplete="new-password"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.password_confirmation"
                            />
                        </div>
                    

                        <div class="form-group mt-4">
                            <button type="submit" name="submit" id="submit" class="form-submit" > Sign Up </button>
                        </div>


                    </form>
                    <p class="loginhere">
                        Have already an account ?

                        <Link
                            :href="route('login')"
                            class="loginhere-link"
                        >
                            Login here
                        </Link>
                    </p>
                  
                </div>
            </div>
        </section>
    </div>
</template>
