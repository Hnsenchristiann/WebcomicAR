<template>
    <div class="bg-cover bg-no-repeat bg-center" :style="'background-image: linear-gradient(rgba(23,167,105,0.3) 50%, rgb(49 46 129)), url(' + karaBackground.default +');'">
        <div class="flex items-end h-screen">
            <div class="w-full p-5">
                <div class="mb-4">
                    <input name="email" for="email" class="shadow appearance-none border rounded-full w-full py-2 px-3 text-grey-darker" v-model="email" id="email" type="text" placeholder="Email">
                </div>
                <div class="pass-form">
                    <input name="password" for="password" class="shadow appearance-none border border-red rounded-full w-full py-2 px-3 text-grey-darker mb-3" v-model="password" id="password" type="password" placeholder="Password">
                </div>
                <div class="text-sm text-center text-white mb-10">
                    <router-link to="#">Forgot Password?</router-link>
                </div>
                <div v-if="loginFailed" class="text-red">Wrong password or email</div>
                <div class="flex items-center justify-between">
                    <button @click="login" class="bg-green-400 w-full hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-full" type="button">
                        LOG IN
                    </button>
                </div>
                <div class="text-m text-center mt-6 text-white">
                    <p>Dont Have Account Yet? <router-link :to="{name: 'register'}">Sign Up</router-link></p>
                </div>
                <div class="flex flex-row items-center justify-center pt-5">
                    <img class="w-10" :src="facebookIcon.default" />
                    <img class="w-10" :src="instagramIcon.default" />
                    <img class="w-10" :src="twitterIcon.default" />
                </div>
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
            loginFailed: false,
            facebookIcon: require('../../../icons/facebook.png'),
            instagramIcon: require('../../../icons/instagram.png'),
            twitterIcon: require('../../../icons/twitter.png'),
            karaBackground: require('../../../assets/kara_bg.jpg'),
        }
    },
    methods:{
        login(){
            this.$store.dispatch('login', {
                email: this.email,
                password: this.password,
            })
            .then(response => {
                this.$router.push({ name: 'dashboard' })
            })
            .catch(error => {
                this.loginFailed = true
            })
        },
    }
}
</script>
