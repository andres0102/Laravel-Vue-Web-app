<template>
    
</template>

<script>
    import ApiService from "../../../components/api/api.service";
    export default {
        props:['companies','companiestypes'],
        name: "MarketMain",
        data(){
            return{
                listCompany:this.companies,
                listCompanyTypes: this.companiestypes,
                page: 1,
                showButton: true,
                sort: false,
                filter: false,
            }
        },
        beforeMount(){

        },
        methods:{
            loadMore(e){
                e.stopPropagation();
                this.$root.showLoading();
                ApiService.get('/api/companies/more/'+this.page, {'sort':this.sort,'filter':this.filter})
                    .then(response => {
                        console.log(response);
                        if(response.data.companies.length){
                            this.listCompany = this.listCompany.concat(response.data.companies);
                        }
                        if(response.data.companies.length < 9){
                            this.showButton = false;
                        }
                        console.log(this.listCompany);
                        this.$root.closeLoading();
                        this.page++;
                    })
                    .catch(error => {
                        console.log(JSON.stringify(error));
                        this.$root.showAlert('Something went wrong, try again later!',false);
                        this.$root.closeLoading();

                    })
                return false;
            },
            loadNew(){
                this.$root.showLoading();
                ApiService.get('/api/companies/more/'+this.page, {'sort':this.sort,'filter':this.filter})
                    .then(response => {
                        console.log(response);
                        console.log('asdas',response.data.companies.length);
                        if(response.data.companies.length){
                            this.listCompany  = response.data.companies;
                        }else{

                            this.listCompany = [];
                        }
                        if(response.data.companies.length < 9){
                            this.showButton = false;
                        }
                        console.log('new',this.listCompany);
                        this.$root.closeLoading();
                        this.page++;
                    })
                    .catch(error => {
                        console.log(JSON.stringify(error));
                        this.$root.showAlert('Something went wrong, try again later!',false);
                        this.$root.closeLoading();

                    });
                return false;
            },
            setSort(){
                this.sort = !this.sort;
                this.page= 0;
                this.loadNew();
            },
            setFilter(filter){
                if(this.filter == filter){
                    this.filter = false;
                }else{
                    this.filter = filter;
                }
                this.page = 0;
                this.loadNew();

            }
        },
        mounted() {
            if(!this.listCompany.length){
                this.showButton = false;
            }
        }
    }
</script>

<style scoped>
.company-desc-link p{
    margin-left: 10px;
}
    .active-head-item{
        color: #000000;
        border-bottom: 1px solid #000000;
    }
    .text-empty{
        text-align: center;
    }
</style>
