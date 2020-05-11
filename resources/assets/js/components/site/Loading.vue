<script>
    export default{
        props:["load"],
        data(){
            return {
            }
        },
        mounted(){
            console.log(this.load);
        },
        methods: {

        },



    }
</script>

<template id="loading">
    <div class="loading-wait" v-show="load"><img src="/assets/img/loading.svg"></div>
</template>
<style>


</style>
