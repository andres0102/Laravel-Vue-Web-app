<script>
    import ApiService from '../../components/api/api.service';
    /*importing slick slider*/
    import Slick from 'vue-slick';

    export default {

        props: ['stableprice','product','user_name','rating_exists'],
        components:{Slick},
        data(){
            return {
                slickOptions: {
                    slidesToShow: 4,
                },
                wishlist: false,
                stbPrice:0,
                model: {
                    options: {},
                    product_id:this.product,
                    price:'',

                },

                errors: [],
                showError: false,
                showRating: this.rating_exists,
                question: {
                    name:this.user_name,
                    email:'',
                    text:'',
                    product_id: this.product,
                    rating:0.5,
                }
            }
        },
        methods:{
            next() {
                if(this.$refs.slick) {
                    this.$refs.slick.next()
                }
            },
            prev() {
                if(this.$refs.slick) {
                    this.$refs.slick.prev()
                }
            },
            reInit() {
                // Helpful if you have to deal with v-for to update dynamic lists
                if(this.$refs.slick) {
                    this.$refs.slick.reSlick()
                }
            },
            changePrice: function(event){
               const option_array = event.target.value.split(':');
               // const option_val = ['group_name':]
                this.model.options[option_array[0]]= {'name' : option_array[1],'price':option_array[2]};
                this.model.price = this.stbPrice;
                for( let key in this.model.options){

                    this.model.price =Number(this.model.price)+ Number(this.model.options[key]['price']);
                }
                this.model.price = "$"+this.model.price.toFixed(2);
            },
            addToBag: function(){
                this.$root.showLoading();
                ApiService.post('/api/bag/add-to-bag',this.model)
                    .then(response => {
                        console.log(response);
                        document.getElementById("cart-items").innerHTML= response.data.count;
                        this.$root.closeLoading();
                        this.$root.showAlert('Added to bag',true);
                        setTimeout(function() {

                        }.bind(this),2000);
                    })
                    .catch(error=>{
                        this.$root.showAlert('Something went wrong',false);
                        console.log(JSON.stringify(error));
                    })
            },
            checkForWishlist(){
                ApiService.get('/api/wishlist/check/'+this.model.product_id)
                    .then(request => {
                        if(request.data.wishlist){
                            this.wishlist = true;
                        }
                    }).catch(error => {
                        console.log(JSON.stringify(error));
                })
            },
            addToWishlist(){
                if(!this.wishlist) {
                    ApiService.post('/api/wishlist/add/'+this.model.product_id)
                        .then(response => {
                            console.log(response.data);
                            if (response.data.wishlist) {
                                this.wishlist = true;
                                this.$root.showAlert('Added to wishlist',true);
                            }
                        });
                }
            },
            sendQuestion(){
                alert(this.question.rating);
                ApiService.post('/api/marketplace/question',this.question)
                    .then(response => {
                        console.log(response);
                        if(response.data.success) {
                            this.$root.showAlert(response.data.text,true);
                            this.question.email='';
                            this.question.text='';
                        }
                    })
                    .catch(error => {
                        if(error.response.data.errors){
                            this.errors = error.response.data.errors;
                            this.showError = true;
                        }else{
                            console.log(JSON.stringify(error));
                            this.$root.showAlert('Something went wrong',false);
                        }


                    });
            }
            ,
            runSlick(){
                document.querySelector('.slick-prev').click();
            }
        },
        mounted() {
            this.model.price ='$'+this.stableprice;
            this.stbPrice=this.stableprice;
            this.checkForWishlist();
        },
    }
</script>
<style>
    fieldset, label { margin: 0; padding: 0; }
    h1 { font-size: 1.5em; margin: 10px; }

    /****** Style Star Rating Widget *****/

    .rating {
        border: none;
        float: left;
    }
    .rating > input { display: none; }
    .rating > label:before {
        margin: 5px;
        font-size: 1.25em;
        font-family: FontAwesome;
        display: inline-block;
        content: "\f005";
    }

    .rating > .half:before {
        content: "\f089";
        position: absolute;
    }

    .rating > label {
        color: #ddd;
        float: right;
    }

    /***** CSS Magic to Highlight Stars on Hover *****/

    .rating > input:checked ~ label, /* show gold star when clicked */
    .rating:not(:checked) > label:hover, /* hover current star */
    .rating:not(:checked) > label:hover ~ label { color: #FFD700;  } /* hover previous stars in list */

    .rating > input:checked + label:hover, /* hover current star when changing rating */
    .rating > input:checked ~ label:hover,
    .rating > label:hover ~ input:checked ~ label, /* lighten current selection */
    .rating > input:checked ~ label:hover ~ label { color: #FFED85;  }
    .form-group {
        margin-bottom: 2rem;
    }
    .product-details .header .image img {
        width: 300px;
        height: 300px;
    }
    .slick-prev:before, .slick-next:before {
        color: black;
    }
</style>
