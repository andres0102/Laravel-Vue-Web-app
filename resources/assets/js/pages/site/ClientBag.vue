<script>
    import ApiService from '../../components/api/api.service';
    export default {
        props: ['total'],
        data() {
            return {
                showLoading:true,
                showError: false,
                error_text:'',
                bagProducts: [],
                totalPrice: 0,
                payment:{
                    cardNumber:'',
                    cardCode:'',
                    cardExMonth:1,
                    cardExYear:2019,
                    cardHolderName:'',
                    company:'',
                    country:'',
                    zip:'',
                    state: '',
                    city: '',
                    address: '',

                }
            }
        },
        methods:{
            calcPrice(bag_item_id,count){
                this.showLoading=true;
                let calcItem = 0;
                if(count == undefined){
                    calcItem = document.getElementById('quantity' + bag_item_id).value;
                }
                let priceItem = document.getElementById('price'+bag_item_id).innerText;
                priceItem = priceItem.replace('$','');
                let totalItem = Number(calcItem) * Number(priceItem);
                totalItem = totalItem.toFixed(2);
                totalItem =totalItem.replace('$','');
                document.getElementById('total'+bag_item_id).innerText ='$'+totalItem;
                if(calcItem <= 0 ){
                    document.getElementById("product"+bag_item_id).remove();
                }
                ApiService.post('/api/bag/update-bag',{bag_id: bag_item_id, quantity: calcItem})
                    .then(response => {
                        if(response.data.total == 0){
                            location.href='/';
                            return ;
                        }
                       this.totalPrice = '$'+ response.data.total.toFixed(2);
                        document.getElementById('cart-items').innerText = response.data.quantity;
                        this.showLoading=false;
                    });


            },
            showErrorBlock(text){
                this.showError = true;
                this.error_text = text;
                setTimeout(function(){
                    this.showError = false;
                }.bind(this),2000);
            },

            sendPayment(){
                this.showLoading=true;
                ApiService.post('/api/bag/payment',this.payment)
                    .then(response=>{
                        console.log(response.data);
                        if(response.data.data.messages.resultCode == 'Ok'){
                            setTimeout(function(){
                                location.href="/?order=success";
                                this.showLoading=true;
                            },2000);

                        }else{
                            this.showErrorBlock(response.data.message);
                        }
                        this.showLoading=false;
                    })
                    .catch(error =>{
                        this.showErrorBlock('Something went wrong, try again letter');
                        this.showLoading=false;
                    })

            }

        },
        beforeMount(){
            this.totalPrice ='$'+ Number(this.total).toFixed(2);
            this.showLoading = false;
        },
        mounted() {
        }
    }
</script>
