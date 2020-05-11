<template>
    <div class="container">
        <div class="header-text"><h2>Wishlist</h2></div>
        <div class="row">
            <div v-for="(product, index) in products" class="col-sm-3">
                <a v-bind:href="product.url">
                    <div class="image-header"><img :src="product.image" /></div>
                    <div class="product-name">{{product.name}}</div>
                </a>
                <button class="btn btn-danger" @click="deleteWishListItem(index, product.wishlist_id)">Delete</button>
            </div>
            <div v-if="wishlistText" class="col-sm-12">{{wishlistText}}</div>
        </div>
    </div>
</template>

<script>
    import ApiService from '../../api/api.service';
    export default{
        data(){
            return {
                products: [],
                wishlistText: ''

            }
        },
        methods: {
          getWishlist(){
              ApiService.get('/api/wishlist/get')
                  .then(response => {
                      if(response.data.wishlist){
                          this.wishlistText = '';
                          console.log(this.products);
                          this.products = response.data.products;

                      }else{
                        this.wishlistText = response.data.answer;
                      }

                  })


          },
            deleteWishListItem(index, wishlist_id){
              ApiService.post('/api/wishlist/remove/'+wishlist_id)
                  .then(response => {
                     if(response.data.type == 'removed'){
                         this.products.splice(index,1);
                         if(this.products.length <=0){
                             this.wishlistText = 'Wishlist is empty';
                         }
                     }
                  });


            }
        },
        beforeMount(){
            this.getWishlist();
        }
    }
</script>
