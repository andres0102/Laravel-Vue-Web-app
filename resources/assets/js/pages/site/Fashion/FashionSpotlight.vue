<template>
    
</template>

<script>
    export default {
        props:['blog_articles','community_articles'],
        name: "FashionSpotlight",
        data(){
            return {
                page_blog_articles: this.blog_articles,
                page_community_articles: this.community_articles,
            }
        }
    }
</script>

<style scoped>

</style>
