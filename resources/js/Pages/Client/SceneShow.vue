<template>
    <div class="flex text-center text-white text-5xl h-screen-navbar w-screen justify-center items-center">
        <div>
            Loading... Please wait
        </div>
    </div>
</template>

<script>
export default {
    name: 'scene-show',
    data(){
        return {
            origHtmlClass: '',
        }
    },
    methods:{
        onXrLoaded(){
            console.log('asdfasdfasdfasdfasdf')
        }
    },
    created(){
        axios.get(route('api.page.show.scene', {page: this.$route.params.pageId}))
        .then((response) => {
            const html = document.getElementsByTagName('html')[0]
            this.origHtmlClass = html.className
            document.body.insertAdjacentHTML('beforeend', response.data.scene)
            window.addEventListener('xrloaded', this.onXrLoaded)
        })
    },
    beforeDestroy(){
        const ascene = document.getElementsByTagName('a-scene')[0]
        ascene.parentNode.removeChild(ascene)
        const eightWallLoading = document.getElementById('loadingContainer')
        if(eightWallLoading !== null){
            eightWallLoading.parentNode.removeChild(eightWallLoading)
        }
        const html = document.getElementsByTagName('html')[0]
        html.className = this.origHtmlClass
        window.removeEventListener('xrloaded', this.onXrLoaded)
    },
}
</script>

<style>
@keyframes spin {
  0% {
    transform: rotate(0);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
