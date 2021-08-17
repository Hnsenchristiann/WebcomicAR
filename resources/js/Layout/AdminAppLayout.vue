<template>
    <div class="text-gray-50 bg-gray-800 pt-2 md:pt-1 pb-1 px-1 mt-0 h-auto w-full z-20 top-0">
        <nav class="bg-gray-800 pt-2 md:pt-1 pb-1 px-1 mt-0 h-auto w-full z-20 top-0">
            <div class="flex flex-wrap items-center">
                <div class="flex flex-shrink md:w-1/3 justify-center md:justify-start text-white">
                    <a href="#">
                        <span class="text-xl pl-2"><i class="em em-grinning"></i></span>
                    </a>
                </div>

                <div class="flex flex-1 md:w-1/3 justify-center md:justify-start text-white px-2">
                    <span class="relative w-full">
                        <input type="search" placeholder="Search" class="w-full bg-gray-900 text-white transition border border-transparent focus:outline-none focus:border-gray-400 rounded py-3 px-2 pl-10 appearance-none leading-normal">
                        <div class="absolute search-icon" style="top: 1rem; left: .8rem;">
                            <svg class="fill-current pointer-events-none text-white w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path>
                            </svg>
                        </div>
                    </span>
                </div>

                <div class="flex w-full content-center justify-between md:w-1/3 md:justify-end">
                    <ul class="list-reset flex justify-between flex-1 md:flex-none items-center">
                        <li class="flex-1 md:flex-none md:mr-3">
                            <router-link to="/logout">Logout</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="flex flex-col md:flex-row">
            <div class="bg-gray-800 shadow-xl h-16 bottom-0 md:relative md:h-auto z-10 w-full md:w-48">
                <div v-for="(item, idx) in items" :key="'link-' + idx" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-pink-500">
                    <router-link :to="item.path">{{item.name}}</router-link>
                </div>
            </div>
            <div class="min-h-screen main-content flex-1 bg-gray-100 md:pb-5 h-auto text-black px-4 pt-4">
                <router-view></router-view>
            </div>
        </div>
    </div>
    <!-- <router-view></router-view> -->
</template>

<script>
export default {
    name: 'app-layout',
    created() {
        let appLayout = this.$router.options.routes.find((el) => {
            return el.name == 'adminAppLayout'
        })
        appLayout.children.forEach(route => {
            this.items.push({
                name: route.name,
                path: route.path
            })
        })
    }
    ,
    data() {
        return {
            items: []
        }
    }
}
</script>
