<template>
    <div>
        <div class="bg-gray-200 p-4">
            <div class="w-full max-w-xl bg-white mx-auto">
                <div class="flex justify-between p-4">
                    <h2> Login </h2>
                    <NuxtLink to="register"> Register </NuxtLink>
                </div>

                <div class="form-group">
                    <label for=""> Email </label>
                    <input type="text" v-model="form.email" class="bg-gray-200/60 text-black px-4 py-2 rounded-md">
                </div>

                <div class="form-group">
                    <label for=""> Password </label>
                    <input type="text" v-model="form.password" class="bg-gray-200/60 text-black px-4 py-2 rounded-md">
                </div>

                <div class="form-group justify-end w-full">
                    <button type="submit" class="bg-blue-700 text-white px-3 py-2 rounded-lg"> Submit </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">

    interface LoginForm {
        password:string,
        email:string,
    }

    const form = ref<LoginForm>({
        password:'',
        email:'',
    });
</script>

<style>
.form-group{
    display: flex;
    flex-direction: column;
    padding: 20px;
}
</style>