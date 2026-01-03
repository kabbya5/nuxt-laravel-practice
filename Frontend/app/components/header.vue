<template>
    <div class="bg-green-600 text-white">
        <div class="container mx-auto">
            <div class="flex justify-end gap-4 py-1">
                <NuxtLink to="/"> Home </NuxtLink>
                <NuxtLink to="/chat"> Chat </NuxtLink>
                <NuxtLink :to="'/login'"> Login </NuxtLink>
            </div>
        </div>
    </div>
</template>