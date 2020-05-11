<template>
    
</template>

<script>
    import ApiService from '../../../components/api/api.service';
    export default {
        name: "ExploreList",
        props:{'list':Array,'categoryurl': String,'typeurl':String, type_id:String},
        data() {
            return {

                items:this.list,
                selectVal:0,
                filter_name:'Nightlife',
            }
        },
        methods:{

            filterItems(){
                if(this.type_id == 2 ){
                    switch (this.selectVal) {
                        case 1:
                            this.filter_name = 'Nightlife';
                            break;
                        case 2:
                            this.filter_name = 'DAYCLUBS/PARTIES';
                            break;
                        default:
                            break;
                    }
                }
                const sendData ={'filter_id':this.selectVal,'categoryurl':this.categoryurl,'typeurl':this.typeurl}
                ApiService.get('/api/explore/filter', sendData)
                    .then(response => {
                        console.log('filter',response.data);
                        if(response.data.items.length > 0) {
                            this.items = response.data.items;
                        }else{
                            this.items = [];
                        }
                    })
                    .catch(error=>{
                       console.log(JSON.stringify(error));
                    });
            },
            onLoadNightLifeFilter(){
                this.selectVal = 1;
                this.filterItems();
            },
        },

        beforeMount(){
            if(this.type_id == 2){
                this.onLoadNightLifeFilter();
            }
        },
        mounted(){
            console.log(this.items);
        }
    }
</script>

<style scoped>
.filter-name{
    margin-right: 10px;
    vertical-align: -webkit-baseline-middle;
    padding-top: 6px;
    text-transform: capitalize;
}
</style>
