<template>
    <div>
        <div class="rounded-xl m-5 bg-gray-200 bg-opacity-70 border border-indigo-600">
            <div class="flex flex-row p-5">
                <div>
                    <img class="w-24 h-36" :src="this.authors.profile_picture_url" />
                </div>
                <div>
                    <div class="ml-4 text-2xl font-bold">
                        {{authors.name}}
                    </div>
                    <div class="ml-4 text-lg mt-3">
                        {{authors.email}}
                    </div>
                    <div>
                        <div class="ml-4 mt-3 text-sm">
                            Social Media :
                        </div>
                        <div class="flex w-8">
                            <div class="w-10"></div>
                            <img class="ml-3" :src="facebookIcon.default" />
                            <img class="ml-5" :src="instagramIcon.default" />
                            <img class="ml-5" :src="twitterIcon.default" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-5">
                <div class="text-xl font-bold">About Authors :</div>
                <div>{{authors.description}}</div>
            </div>
            <div class="p-5">
                <div class="text-xl font-bold">Author Books :</div>
                <div class="mb-3">
                    <div>
                        <horizontal-slider :items="processToHorizontalSlider(comics.all.comics)"
                                        :config="config"
                                        objectCategory="all"
                                        @nextPage="nextPage"></horizontal-slider>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import HorizontalSlider from '../../Components/HorizontalSlider.vue'
    export default {
        name: 'author',
        components: {
            HorizontalSlider
        },
        data() {
            return {
                facebookIcon: require('../../../icons/facebook.png'),
                instagramIcon: require('../../../icons/instagram.png'),
                twitterIcon: require('../../../icons/twitter.png'),
                authors: [],
                shownTags: [
                    'asdf',
                    'lorem'
                ],
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
                }
            }
        },
        created() {
            this.shownTags.forEach((elem) => {
                this.comics[elem] = {}
                this.comics[elem].comics = []
                this.getComics(route('api.comics.list', { ...this.query, where_tag: elem }), elem)
            })
            this.getComics(route('api.comics.list', this.query), 'all')
            axios.get(route('api.author.show', { author: this.$route.params.authorId }))
                .then((response) => {
                    this.authors = response.data
                })
        },
        methods: {
            processToHorizontalSlider(comicObjects) {
                let retVal = []
                comicObjects.forEach(element => {
                    retVal.push({
                        url: '/comic/' + element.id,
                        cover_url: element.cover_url,
                        title: element.title
                    })
                });
                return retVal
            },
            getComics(url, category) {
                axios.get(url)
                    .then((response) => {
                        if (!this.comics[category]) {
                            this.comics[category] = {}
                            this.comics[category].comics = response.data.data
                        } else {
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
            nextPage(category) {
                if (!this.comics[category].nextDisabled) {
                    this.getComics(this.comics[category].nextPageUrl, category)
                }
            },
            prevPage(category) {
            }
        }
    }
</script>

<style>
</style>
