<template>
    <div>
        <div>
            <div class="">
                <div class="bg-gray-300 w-full h-10 border-t-2 border-b-2 border-black">
                    <div class="text-center text-lg pt-1">Favorite Comic</div>
                </div>
            </div>
            <div class="px-5 pt-5">
                <horizontal-slider :items="processToHorizontalSlider(comics.all)"
                                   :config="config"
                                   objectCategory="all"
                                   @nextPage="nextPage"></horizontal-slider>
            </div>
        </div>
        <div>
            <div class="pt-5">
                <div class="bg-gray-300 w-full h-10 border-t-2 border-b-2 border-black">
                    <div class="text-center text-lg pt-1">My Comic</div>
                </div>
            </div>
            <div class="px-5 pt-5">
                <horizontal-slider :items="processToHorizontalSlider(comics.all)"
                                   :config="config"
                                   objectCategory="all"
                                   @nextPage="nextPage"></horizontal-slider>
            </div>
        </div>
        <div>
            <div class="pt-5">
                <div class="bg-gray-300 w-full h-10 border-t-2 border-b-2 border-black">
                    <div class="text-center text-lg pt-1">Subscribed Comic</div>
                </div>
            </div>
            <div class="px-5 py-5">
                <horizontal-slider :items="processToHorizontalSlider(comics.all)"
                                   :config="config"
                                   objectCategory="all"
                                   @nextPage="nextPage"></horizontal-slider>
            </div>
        </div>
    </div>
</template>

<script>
    import HorizontalSlider from '../../Components/HorizontalSlider.vue'
    export default {
        name: 'mycomic',
        components: {
            HorizontalSlider
        },
        created() {
            this.shownTags.forEach((elem) => {
                this.comics[elem] = {}
                this.comics[elem].comics = []
                this.getComics(route('api.comics.list', { ...this.query, where_tag: elem }), elem)
            })
            this.getComics(route('api.comics.list', this.query), 'all')
        },
        data() {
            return {
                shownTags: [
                    'ipsum',
                    'lorem'
                ],
                comics: {
                    all: {
                        comics: []
                    }
                },
                query: {
                    paginate: 14,
                    page: 1
                },
                config: {
                    image: 'cover_url',
                    title: 'title'
                },
            }
        },
        methods: {
            processToHorizontalSlider(comicObjects) {
                let retVal = []
                comicObjects.comics.forEach(element => {
                    retVal.push({
                        url: '/comic/' + element.id,
                        cover_url: element.cover_url,
                        title: element.title
                    })
                });
                return { items: retVal, nextPageUrl: comicObjects.nextPageUrl }
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
