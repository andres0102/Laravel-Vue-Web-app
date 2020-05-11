<template>
    
</template>

<script>
    import ApiService from "../../../components/api/api.service";
    export default {
        name: "MarketProducts",
        props:['products','company_id'],
        data(){
            return{
                showMore: true,
                listProducts: this.products,
                category:false,
                page: 1,
            }
        },
        methods:{
          loadMore(){
              this.$root.showLoading();
            ApiService.get('/api/companies/morep/'+this.company_id+'/'+this.page,{'category':this.category})
                .then(response=>{
                    if(response.data.products.length) {
                        this.listProducts = this.listProducts.concat(response.data.products);
                    }else{
                        this.showMore = false;
                    }
                    if(response.data.products.length < 9){
                        this.showMore = false;
                    }else{
                        this.showMore = true;
                    }
                    this.$root.closeLoading();
                    this.page++;
              })
                .catch(error => {
                    this.$root.showAlert('Something went wrong, try again later!',false);
                    this.$root.closeLoading();
                    console.log(JSON.stringify(error));
                });

          },
            loadNew(){
              this.page = 0;
                this.$root.showLoading();
                ApiService.get('/api/companies/morep/'+this.company_id+'/'+this.page,{'category':this.category})
                    .then(response=>{
                        console.log(response);
                        if(response.data.products.length) {
                            this.listProducts = response.data.products;
                        }else{
                            this.showMore = false;
                        }
                        if(response.data.products.length < 9){
                            this.showMore = false;
                        }else{
                            this.showMore = true;
                        }
                        this.$root.closeLoading();
                        this.page=1;
                    })
                    .catch(error => {
                        this.$root.showAlert('Something went wrong, try again later!',false);
                        this.$root.closeLoading();
                        console.log(JSON.stringify(error));
                    });
            },
            filter(category_id){
              if(category_id){
                  this.category = category_id;
              }
              this.loadNew();
            }
        },
        mounted() {
            if(this.listProducts.length < 9){
                this.showMore = false;
            }
            console.log(this.listProducts);
        }
    }
</script>

<style scoped>

</style>
