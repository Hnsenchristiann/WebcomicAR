<template>
    <div class="flex justify-center">
        <div class="w-1/3">
            <div class="mb-4">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="email">
                    Username
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" v-model="email" id="email" type="text" placeholder="Username">
            </div>
            <div class="mb-6">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3" v-model="password" id="password" type="password" placeholder="******************">
                <p class="text-red text-xs italic">Please choose a password.</p>
            </div>
            <div class="flex items-center justify-between">
                <button @click="login" class="bg-blue-500 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded" type="button">
                    Sign In
                </button>
                <a class="inline-block align-baseline font-bold text-sm text-blue hover:text-blue-darker" href="#">
                    Forgot Password?
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:'login',
    data(){
        return {
            email: '',
            password: '',
        }
    },
    methods:{
        login(){
            this.$store.dispatch('login', {
                email: this.email,
                password: this.password,
            })
            .then(response => {
                this.$router.push({ name: 'adminHome' })
            })
            .catch(error => {

            })
        },
    }
}
</script>