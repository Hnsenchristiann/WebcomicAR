<template>
    <div class="text-gray-50 bg-gray-800 mt-0 h-auto w-full z-20 top-0 font-sans">
        <nav class="bg-gray-800">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                <div class="relative flex items-center justify-between h-16">
                    <div class="absolute ml-12 inset-y-0 left-0 flex items-center sm:hidden">
                        <!-- Mobile menu button-->
                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6 lg:hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                        <div class="flex-shrink-0 flex items-center">
                            <img class="block h-16 w-auto" :src="visi8Icon.default" alt="Workflow">
                            <img class="hidden lg:block h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg" alt="Workflow">
                        </div>
                        <div class="hidden lg:block">
                            <div class="ml-5">
                                <router-link :to="{name: 'dashboard'}">Dashboard</router-link>
                                <router-link class="ml-5" :to="{}">My Comic</router-link>
                                <router-link class="ml-5" :to="{}">My Account</router-link>
                            </div>
                        </div>
                        <div class="hidden sm:block sm:ml-6">
                            <div class="flex space-x-4">
                                <router-link @click="mobileMenuOpen = false" :to="{name: 'dashboard'}" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Dashboard</router-link>
                                <router-link :to="{}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Team</router-link>
                                <router-link :to="{}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Projects</router-link>
                                <router-link :to="{}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Calendar</router-link>
                            </div>
                        </div>
                    </div>
                    <div v-if="isLoggedIn" class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                        <!-- Profile dropdown -->
                        <span class="badge" v-if="cartCount > 0">{{cartCount}}</span>
                        <svg @click="goToPayment" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <div class="ml-3 relative">
                            <div>
                                <button @click="profileMenuOpen = !profileMenuOpen" type="button" class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                </button>
                            </div>
                            <div v-if="profileMenuOpen" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                <!-- Active: "bg-gray-100", Not Active: "" -->
                                <router-link :to="{name: 'logout'}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</router-link>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <router-link :to="{name: 'login'}">Login</router-link>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <transition name="slide">
                <div class="sm:hidden bg-gray-800 absolute w-full" id="mobile-menu" v-if="mobileMenuOpen">
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        <router-link @click.native="mobileMenuOpen = false" :to="{name: 'dashboard'}" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium" aria-current="page">Dashboard</router-link>
                        <router-link :to="{name: 'mycomic'}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">My Comics</router-link>
                        <router-link :to="{}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">My Account</router-link>
                    </div>
                </div>
            </transition>
        </nav>
        <div class="flex flex-col md:flex-row">
            <!-- <div class="bg-gray-800 shadow-xl h-16 bottom-0 md:relative md:h-auto z-10 w-full md:w-48">
                <div v-for="(item, idx) in items" :key="'link-' + idx" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-pink-500">
                    <router-link :to="item.path">{{item.name}}</router-link>
                </div>
            </div> -->
            <div class="min-h-screen main-content flex-1 bg-gradient-to-t from-purple-800 to-indigo-900 md:pb-5 h-auto text-black">
                <router-view :key="$route.fullPath"></router-view>
            </div>
        </div>
        <div class="lg:hidden">
            <div class="w-100 bg-gray-800 divide-y text-center h-full">
                <div class="h-12 py-2"><router-link :to="{name: 'about'}">About Us</router-link></div>
                <div class="h-12 py-2"><router-link :to="{name: 'myaccount'}">My Account</router-link></div>
                <div class="h-12 py-2"><router-link :to="{name: 'privacy'}">Privacy Policy</router-link></div>
                <div class="h-12 py-2"><router-link :to="{}">FAQ</router-link></div>
                <div class="py-2">
                    Follow Us On
                    <div class="flex w-full flex flex-row items-center justify-center mt-2">
                        <img class="w-12" :src="facebookIcon.default" />
                        <img class="w-12" :src="instagramIcon.default" />
                        <img class="w-12" :src="twitterIcon.default" />
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:block">
            <div class="bg-gray-800 h-full">
                <div class="flex items-center justify-center mt-10">
                    <div class="divide-x">
                        <router-link class="mr-5" :to="{name: 'about'}">About Us</router-link>
                        <router-link class="px-5" :to="{name: 'about'}">My Account</router-link>
                        <router-link class="px-5" :to="{name: 'privacy'}">Privacy Policy</router-link>
                        <router-link class="px-5" :to="{name: 'about'}">FAQ</router-link>
                    </div>
                </div>
                <div class="py-5 text-center">
                    Follow Us On
                    <div class="flex w-full flex flex-row items-center justify-center mt-2">
                        <img class="w-12" :src="facebookIcon.default" />
                        <img class="w-12" :src="instagramIcon.default" />
                        <img class="w-12" :src="twitterIcon.default" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'app-layout',
    methods: {
        goToPayment(){
            this.$router.push({name: 'paymentShow'})
        },
        countCartItems(){
            let count = 0
            let cartObj = JSON.parse(localStorage.getItem('cart') || '{}')
            Object.keys(cartObj).forEach((key) => {
                count += cartObj[key].length
            })
            this.cartCount = count
        }
    },
    created() {
        this.isLoggedIn = this.$store.getters.loggedIn
        if(this.$store.getters.loggedIn){
            this.$store.commit('setAxiosCurrentToken')
        }
        let appLayout = this.$router.options.routes.find((el) => {
            return el.name == 'appLayout'
        })
        appLayout.children.forEach(route => {
            this.items.push({
                name: route.name,
                path: route.path
            })
        })
        this.countCartItems()
        eventBus.$on('cartAddItem', (e) => {
            this.countCartItems()
        })
    },
    data() {
        return {
            cartCount: 0,
            items: [],
            mobileMenuOpen: false,
            profileMenuOpen: false,
            isLoggedIn: false,
            facebookIcon: require('../../icons/facebook.png'),
            instagramIcon: require('../../icons/instagram.png'),
            twitterIcon: require('../../icons/twitter.png'),
            visi8Icon: require('../../assets/visi8_logo.png')
        }
    }
}
</script>
<style>
#mobile-menu{
    z-index: 900;
}
.slide-enter-active {
   -moz-transition-duration: 0.3s;
   -webkit-transition-duration: 0.3s;
   -o-transition-duration: 0.3s;
   transition-duration: 0.3s;
   -moz-transition-timing-function: ease-in;
   -webkit-transition-timing-function: ease-in;
   -o-transition-timing-function: ease-in;
   transition-timing-function: ease-in;
}

.slide-leave-active {
   -moz-transition-duration: 0.3s;
   -webkit-transition-duration: 0.3s;
   -o-transition-duration: 0.3s;
   transition-duration: 0.3s;
   -moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
   -webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
   -o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
   transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
}

.slide-enter-to, .slide-leave {
   max-height: 100px;
   overflow: hidden;
}

.slide-enter, .slide-leave-to {
   overflow: hidden;
   max-height: 0;
}
.badge{
    position: relative;
    top: -13px;
    right: -34px;
    padding: 0px 5px;
    border-radius: 50%;
    background: red;
    font-size: 12px;
    color: white;
    pointer-events: none;
}
</style>
