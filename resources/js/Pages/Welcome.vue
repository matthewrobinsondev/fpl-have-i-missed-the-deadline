<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { defineProps, ref, computed, watchEffect } from 'vue';

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    missedDeadline: {
        type: Boolean
    },
    deadlineTime: {
        type: String
    }
});

const currentTime = ref(Date.now());

watchEffect(() => {
    setInterval(() => {
        currentTime.value = Date.now();
    }, 1000);
});

const countdown = computed(() => {
    const deadlineTimestamp = Date.parse(props.deadlineTime);
    const currentTimestamp = currentTime.value;

    if (deadlineTimestamp < currentTimestamp) {
        return 'Deadline has passed';
    }

    const secondsRemaining = Math.floor((deadlineTimestamp - currentTimestamp) / 1000);
    const hours = Math.floor(secondsRemaining / 3600);
    const minutes = Math.floor((secondsRemaining % 3600) / 60);
    const seconds = secondsRemaining % 60;

    return `${hours}h ${minutes}m ${seconds}s`;
});
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
    >
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Dashboard</Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Log in</Link
                >

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Register</Link
                >
            </template>
        </div>

        <div class="p-6 lg:p-8">
            <div v-if="missedDeadline">
                <h1 class="text-5xl font-extrabold text-red-600 animate-bounce">
                    YOU HAVE MISSED THE DEADLINE!
                </h1>
                <h3 class="text-2xl dark:text-gray-100 light:text-gray-900">Deadline was: {{deadlineTime}}</h3>
            </div>

            <div v-else>
                <h1 class="text-5xl font-extrabold text-green-600 animate-bounce">
                    YOU'VE NOT MISSED THE DEADLINE!
                </h1>
                <h3 class="dark:text-gray-100 light:text-gray-900">Deadline is in: {{countdown}}</h3>
            </div>
        </div>
    </div>
</template>

<style>

</style>
