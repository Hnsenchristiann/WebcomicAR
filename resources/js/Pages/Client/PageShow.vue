<template>
    <div class="w-full">
        <div class="w-full mt-1 mb-2 px-5 py-2">
            <label for="chapter" class="text-white">Select chapter</label>
            <div class="flex">
                <select class="rounded-lg form-select block w-full mt-1" @change="changeChapter(selectedChapter)" v-model="selectedChapter">
                    <option v-for="(chapter, idx) in chapters" :value="chapter" :key="'cpt-' + idx">Episode {{chapter}}</option>
                </select>
                <!-- <svg @click="prevChapter" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-1 mr-1" fill="none" viewBox="0 0 24 24" :stroke="prevEnabled ? '#2f2f2f' : '#919191'">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <select class="form-select block w-full mt-1" @change="changeChapter(selectedChapter)" v-model="selectedChapter">
                    <option v-for="(chapter, idx) in chapters" :value="chapter" :key="'cpt-' + idx">{{chapter}}</option>
                </select>
                <svg @click="nextChapter" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-1 ml-1" fill="none" viewBox="0 0 24 24" :stroke="nextEnabled ? '#2f2f2f' : '#919191'">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg> -->
            </div>
        </div>
        <template v-for="(page, idx) in pages">
            <div v-if="page.id in scenePages && isAr" :class="{glow: shownClass['ar-' + page.id], 'fill-width': !shownClass['ar-' + page.id]}" class="w-100 glow-animation lg:object-fill" :key="'img-' + idx" :id="'ar-' + page.id">
                <router-link :to="{name: 'sceneShow', params: {pageId: page.id}}">
                    <img :src="page.image_url">
                </router-link>
            </div>
            <div v-else class="lg:object-fill" :key="'img-' + idx">
                <img class="lg:object-fill" :src="page.image_url">
            </div>
        </template>
        <!-- <div :class="{glow: shownClass['ar-' + page.id], 'fill-width': !shownClass['ar-' + page.id]}" class="w-100 glow-animation" v-for="(page, idx) in pages" :key="'img-' + idx" :id="page.id in scenePages ? 'ar-' + page.id : null">
            <img :src="page.image_url">
        </div> -->
        <div class="flex justify-center mt-8 pb-5">
            <button @click="prevChapter" class="flex bg-indigo-900 h-8 w-20 text-white rounded-lg justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-1 mr-1" fill="none" viewBox="0 0 24 24" :stroke="prevEnabled ? '#919191' : '#2f2f2f'">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <div class="mt-1">Prev</div>
            </button>
            <button @click="nextChapter" class="ml-5 flex bg-indigo-900 h-8 w-20 text-white rounded-lg justify-center">
                <div class="mt-1">Next</div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-1 ml-1" fill="none" viewBox="0 0 24 24" :stroke="nextEnabled ? '#919191' : '#2f2f2f'">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name:'page',
    data(){
        return {
            pages: [],
            chapters: [],
            selectedChapter: this.$route.params.chapter,
            prevEnabled: false,
            nextEnabled: false,
            scenePages: {},
            shownClass: {},
            arElems: {},
            isAr: false
        }
    },
    methods:{
        changeChapter(newchapter){
            // this.fetchPages(this.$route.params.comicId, this.selectedChapter)
            this.$router.push({name: 'pageShow',
                params: {
                    comicId: this.$route.params.comicId,
                    chapter: newchapter
                },
                query: {
                    ar: this.isAr
                }
            })
        },
        nextChapter(){
            if(this.nextEnabled){
                let currentChapter = this.chapters.length - (this.chapters.slice().reverse().findIndex((el) => el == this.$route.params.chapter)) - 1
                this.changeChapter(this.chapters[currentChapter + 1])
            }
        },
        prevChapter(){
            if(this.prevEnabled){
                let currentChapter = this.chapters.length - (this.chapters.slice().reverse().findIndex((el) => el == this.$route.params.chapter)) - 1
                this.changeChapter(this.chapters[currentChapter - 1])
            }
        },
        fetchChapters(comicId){
            return axios.get(route('api.comic.get.chapters', {comicId: comicId}))
            .then((response) => {
                this.chapters = response.data
            })
            .catch((error) => {

            })
        },
        fetchPages(comicId, chapter){
            return axios.get(route('api.pages.show', {
                comicId: comicId,
                chapter: chapter
            }))
            .then((response) => {
                this.pages = response.data
                return response
            })
            .catch((error) => {

            })

        },
        handleScroll(e){
            if(!this.isAr){
                return
            }
            let shownClass = {}
            Object.keys(this.arElems).forEach((el, idx) => {
                if(this.isInViewport(this.arElems[el])){
                    shownClass['ar-' + el] = true
                }else{
                    shownClass['ar-' + el] = false
                }
            })
            this.shownClass = shownClass
        },
        isInViewport(element){
            const rect = element.getBoundingClientRect();
            const bottom = rect.bottom < (window.innerHeight / 1.5) ? rect.bottom : rect.bottom / 1.5
            const right = rect.right - 1
            const visible = (
                rect.top >= 0 &&
                rect.left >= 0 &&
                bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                right <= (window.innerWidth || document.documentElement.clientWidth)
            )
            return visible;
        }
    },
    destroyed(){
        window.removeEventListener('scroll', this.handleScroll)
    },
    mounted(){
        // window.addEventListener('scroll', this.handleScroll)
    },
    created(){
        this.isAr = this.$route.query.ar
        axios.get(route('api.author.show', {author:1}))
        this.fetchChapters(this.$route.params.comicId)
        .then((resp) => {
            this.prevEnabled = this.$route.params.chapter != this.chapters[0]
            this.nextEnabled = this.$route.params.chapter != this.chapters[this.chapters.length - 1]
        })
        this.fetchPages(this.$route.params.comicId, this.$route.params.chapter)
        .then((resp) => {
            let k = {}
            this.pages.filter((el) => {
                return !!el.scene
            }).forEach((el) => {
                k[el.id] = el.scene
            })
            this.scenePages = k

            this.$nextTick(() => {
                let elems = {}
                Object.keys(this.scenePages).forEach((el) => {
                    elems[el] = document.getElementById('ar-' + el)
                })
                this.arElems = elems
                this.handleScroll()
                window.addEventListener('scroll', this.handleScroll)
            })
        })
        .then((resp) => {
            return axios.get(route('api.page.bookmark', {pageId: this.pages[0].id}))
        })
    },
}
</script>

<style>
.glow{
    box-shadow: 0 0 15px 3px #FFF, 0 0 8px 2px #f0f, 0 0 5px 5px #0FF;
    /* width: 80.5vw; */
    z-index: 99;
    margin-bottom:2px;
    transform: scale(0.98, 0.99) !important;
    /* transition-property: transform;
    transition-duration: 0.5s;
    transition-timing-function: ease !important; */
}
.glow-animation{
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}
.full-width{
    width: 100%;
}
</style>
