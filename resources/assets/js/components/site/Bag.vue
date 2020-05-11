<script>
    import ApiService from '../api/api.service';
    export default {
        data() {
            return {
                itemBag:0
            }
        },
        methods:{
          getBagCount: function() {
              ApiService.post('/api/bag/check-bag')
                  .then(response => {
                      this.itemBag = response.data.count;
                  })
                  .catch(error => {
                      console.log(JSON.stringify(error));
                  })

          },
        },
        beforeMount(){
            this.getBagCount();
        },
        mounted() {

        }
    }
</script>
