<template>
    <div class="pa-2 w-full">
        <div class="flex flex-col justify-end items-center bg-blue-100 w-150 h-40 pb-8 featured-block" style="background-image: linear-gradient(rgba(245, 246, 252, 0) 50%, rgb(49 46 129)), url(/storage/media/covers/kara.jpg);"> <!-- add featured comic here -->
            <div class="mb-6 text-white">
                <img class="w-64" :src="karaIcon.default" />
                <div class="mb-6 text-white">
                    <div class="text-center text-base subsubtitle">Adventure, Teen, Magical</div>
                </div>
            </div>
        </div>
        <div class="px-5 pb-5 bg-gradient-to-t  to-indigo-900 from-purple-900">
            <div class="mb-3 text-white">
                <div>
                    <div class="text-white float-right">More</div>
                    <div>New Releases</div>
                </div>
                <div>
                    <horizontal-slider
                        :items="processToHorizontalSlider(comics.all)"
                        :config="config"
                        objectCategory="all"
                        @nextPage="nextPage"
                    ></horizontal-slider>
                </div>
            </div>
            <div class="mb-3 text-white" v-for="(tag, idx) in shownTags" :key="'tag-' + idx">
                <div>
                    <div class="text-white float-right">More</div>
                    <div>{{$_.startCase($_.toLower(tag))}}</div>
                </div>
                <div>
                    <horizontal-slider
                        :items="processToHorizontalSlider(comics[tag])"
                        :config="config"
                        :objectCategory="tag"
                        @nextPage="nextPage"
                    ></horizontal-slider>
                </div>
            </div>
        </div>
        <div class="px-5 py-5 bg-gray-100">
            <div class="mb-3">
                <div>
                    <div class="float-right">More</div>
                    <div>Authors</div>
                </div>
                <div>
                    <horizontal-slider
                        :items="processToAuthorHorizontalSlider(authors.all)"
                        :config="configAuthor"
                        objectCategory="all"
                        @nextPage="nextAuthorPage"
                    ></horizontal-slider>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import HorizontalSlider from '../../Components/HorizontalSlider.vue'
export default {
    name: 'dashboard',
    components: {
        HorizontalSlider
    },
    created(){
        this.shownTags.forEach((elem) => {
            this.comics[elem] = {}
            this.comics[elem].comics = []
            this.getComics(route('api.comics.list', {...this.query, where_tag: elem}), elem)
        })
        this.getComics(route('api.comics.list', this.query), 'all')
        this.getAuthors(route('api.authors.list', this.query), 'all')
    },
    data(){
        return {
            shownTags: [
                'ipsum',
                'lorem'
            ],
            authors: {
                all: {
                    authors: []
                }
            },
            comics: {
                all: {
                    comics: []
                }
            },
            query: {
                paginate: 5,
                page: 1
            },
            config: {
                image: 'cover_url',
                title: 'title'
            },
            configAuthor: {
                image: 'cover_url',
                title: 'title'
            },
            karaIcon: require('../../../assets/kara_logo.png')
        }
    },
    methods:{
        processToAuthorHorizontalSlider(authorObjects){
            let retVal = []
            console.log(authorObjects)
            authorObjects.authors.forEach(element => {
                retVal.push({
                    url: '/author/' + element.id,
                    cover_url: element.profile_picture_url,
                    title: element.name
                })
            });
            return {items: retVal, nextPageUrl: authorObjects.nextPageUrl}
        },
        processToHorizontalSlider(comicObjects){
            let retVal = []
            comicObjects.comics.forEach(element => {
                retVal.push({
                    url: '/comic/' + element.id,
                    cover_url: element.cover_url,
                    title: element.title
                })
            });
            return {items: retVal, nextPageUrl: comicObjects.nextPageUrl}
        },
        getAuthors(url, category){
            axios.get(url)
            .then((response) => {
                if(!this.authors[category]){
                    this.authors[category] = {}
                    this.authors[category].authors = response.data.data
                }else{
                    this.authors[category].authors = this.authors[category].authors.concat(response.data.data)
                }
                this.authors[category].paginationData = response.data
                this.authors[category].prevDisabled = this.authors[category].paginationData.prev_page_url === null
                this.authors[category].nextDisabled = this.authors[category].paginationData.next_page_url === null
                this.authors[category].prevPageUrl = this.authors[category].paginationData.prev_page_url
                this.authors[category].nextPageUrl = this.authors[category].paginationData.next_page_url
            })
            .catch((error) => {
                //do error catching later
            })
        },
        getComics(url, category){
            axios.get(url)
            .then((response) => {
                if(!this.comics[category]){
                    this.comics[category] = {}
                    this.comics[category].comics = response.data.data
                }else{
                    this.comics[category].comics = this.comics[category].comics.concat(response.data.data)
                }
                this.comics[category].paginationData = response.data
                this.comics[category].prevDisabled = this.comics[category].paginationData.prev_page_url === null
                this.comics[category].nextDisabled = this.comics[category].paginationData.next_page_url === null
                this.comics[category].prevPageUrl = this.comics[category].paginationData.prev_page_url
                this.comics[category].nextPageUrl = this.comics[category].paginationData.next_page_url
            })
            .catch((error) => {
                //do error catching later
            })
        },
        nextAuthorPage(category){
            if(!this.authors[category].nextDisabled){
                this.getAuthors(this.authors[category].nextPageUrl, category)
            }
        },
        nextPage(category){
            if(!this.comics[category].nextDisabled){
                this.getComics(this.comics[category].nextPageUrl, category)
            }
        },
        prevPage(category){

        }
    }
}
</script>

<style>
.subsubtitle{
    color: #41b3a9;
}
.featured-block{
    height: calc(100vh - 64px);
    background-size: cover;
    background-position: center;
}
</style>
