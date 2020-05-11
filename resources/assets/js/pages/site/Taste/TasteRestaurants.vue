<template>
    
</template>

<script>
    import ApiService from '../../../components/api/api.service';
    export default {
        props:['companies','place_id'],
        name: "TasteRestaurants",
        data(){
            return{
                list_companies:this.companies,
                location:'false',
                search_value:'',
            }
        },
        mounted() {
            console.log(this.list_companies);
        },
        methods: {
            filterItems(){
                this.$root.showLoading();
                ApiService.get('/api/taste/filter',{'place_id':this.place_id,'location':this.location})
                    .then(response => {
                      this.list_companies = response.data.companies;
                        this.$root.closeLoading();
                    })
                    .catch( error => {
                       console.log(JSON.stringify(error));
                        this.$root.closeLoading();
                    });
            },
            searchItems(){
                if(this.search_value) {
                    this.$root.showLoading();
                    ApiService.get('/api/taste/search', {'place_id': this.place_id, 'search': this.search_value})
                        .then(response => {
                            this.list_companies = response.data.companies;
                            this.$root.closeLoading();
                        })
                        .catch(error => {
                            console.log(JSON.stringify(error));
                            this.$root.closeLoading();
                        });
                }else{
                    this.$root.showAlert("Enter text in search",1);
                }
            }

        },


    }
</script>

<style scoped>

</style>
