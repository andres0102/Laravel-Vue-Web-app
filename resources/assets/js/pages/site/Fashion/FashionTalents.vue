<template>
    
</template>

<script>
    import ApiService from '../../../components/api/api.service';
    export default {
        props:['talents'],
        name: "FashionTalents",
        data(){
            return {
                page_talents: this.talents,
                showLoading: true,
                page:1,
            }
        },
        methods:{
            loadMore(){
                this.$root.showLoading();
                ApiService.get('/api/fashion/more-talents',{'page':this.page})
                    .then(response=>{
                        if(response.data.talents.length > 0){
                            this.page_talents = this.page_talents.concat(response.data.talents);
                            if(response.data.talents.length < 6){
                                this.showLoading = false;
                            }
                        }else{
                            this.showLoading = false;
                        }
                        this.$root.closeLoading();

                    })
                    .catch(error=>{
                       console.log(JSON.stringify(error));
                        this.$root.closeLoading();
                    });
            }
        },
        mounted() {
            if(this.page_talents.length < 6){
                this.showLoading = false;
            }
        }
    }
</script>

<style scoped>
.load-more a{
    color: white;
}

</style>
