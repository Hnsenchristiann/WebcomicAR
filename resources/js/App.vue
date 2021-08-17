<template>
    <router-view></router-view>
</template>

<script>
export default {
    name: 'webcomic',
    created() {
        this.$router.options.routes.forEach(route => {
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