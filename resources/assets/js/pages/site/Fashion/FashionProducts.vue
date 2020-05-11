<script>
    import ApiService from "../../../components/api/api.service";
    export default {
        props:['products','category_id','type'],
        data(){
            return{
                listProducts: this.products,
                showMore: true,
                page: 1,
                sortValue:0,
            }
        },
        methods:{
            sortProducts(){
                this.$root.showLoading();
                ApiService.get('/api/fashion/products/sort',{'type':this.type,'sort':this.sortValue})
                    .then(response => {
                        this.listProducts = response.data.products;
                        console.log(response.data);
                        if(response.data.products.length < 9){
                            this.showMore = false;
                        }else{
                            this.showMore = true;
                        }
                        this.$root.closeLoading();
                    })
                    .catch(error => {
                        console.log(JSON.stringify(error));
                        this.$root.closeLoading();
                    });

            },
          loadMore(){
              this.$root.showLoading();
              ApiService.get('/api/fashion/morp/'+this.type+'/'+this.page,{'sort':this.sortValue})
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

          }
        },
        mounted() {
            if(this.listProducts.length < 9){
                this.showMore = false;
            }
        }
    }
</script>
