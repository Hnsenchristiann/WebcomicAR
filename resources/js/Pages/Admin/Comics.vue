<template>
    <div class="flex">
        <div class="w-1/2">
            <button class="mb-4 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                Create New Comic
            </button>
            <div v-for="(comic, idx) in comics" :key="'comic-' + idx" class="bg-white space-y-3 px-6 py-4 mb-2 shadow-lg border flex flex-col">
                <div>
                    <div>Title:</div>
                    <div>{{comic.title}}</div>
                </div>
                <div>
                    <div>Description:</div>
                    <div>{{comic.description}}</div>
                </div>
                <div>
                    <div>Cover:</div>
                    <div><img :src="comic.cover_url"></div>
                </div>
            </div>
            <div class="inline-flex">
                <button @click="getPrevPage" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" :class="{'opacity-50': prevDisabled, 'cursor-not-allowed': prevDisabled}">
                    Prev
                </button>
                <button @click="getNextPage" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" :class="{'opacity-50': nextDisabled, 'cursor-not-allowed': nextDisabled}">
                    Next
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'comics',
    data(){
        return {
            comics: [],
            query: {
                paginate: 5,
                page: 1
            },
            paginationData: {},
            nextDisabled: false,
            prevDisabled: false,
            nextPageUrl: '',
            prevPageUrl: '',
        }
    },
    created(){
        this.getPage(route('api.comics.list', this.query))
    },
    methods:{
        getPage(url){
            if(url !== null){
                axios.get(url)
                .then((response) => {
                    this.paginationData = response.data
                    this.comics = response.data.data
                    this.prevDisabled = this.paginationData.prev_page_url === null
                    this.nextDisabled = this.paginationData.next_page_url === null
                    this.prevPageUrl = this.paginationData.prev_page_url
                    this.nextPageUrl = this.paginationData.next_page_url
                })
            }
        },
        getNextPage(){
            if(!this.nextDisabled){
                this.getPage(this.nextPageUrl)
            }
        },
        getPrevPage(){
            if(!this.prevDisabled){
                this.getPage(this.prevPageUrl)
            }
        }
    }

}
</script>

<style scoped>

</style>