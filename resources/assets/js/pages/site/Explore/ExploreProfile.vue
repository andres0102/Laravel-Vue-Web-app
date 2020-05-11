<template>
    
</template>

<script>
    import carousel from 'vue-owl-carousel';
    export default {
        name: "ExploreProfile",
        components:{carousel},
        methods: {

        },
        mounted() {
        }
    }
</script>

<style >
    @media screen and (min-width: 760px) {
        #services .owl-carousel.owl-drag .owl-item {
            min-width: 300px !important;

        }

        #services .owl-stage {
            width: 100% !important;
        }
    }
</style>
