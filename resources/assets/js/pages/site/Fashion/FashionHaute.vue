<template>
    
</template>

<script>
    export default {
        props:['fashion_ed_articles','fashion_scoop_articles','talents'],
        name: "FashionHaute",
        data(){
            return{
                page_fash_edit:this.fashion_ed_articles,
                page_fash_scoop:this.fashion_scoop_articles,
                page_talents:this.talents,
            }
        }
    }
</script>

<style scoped>

</style>
