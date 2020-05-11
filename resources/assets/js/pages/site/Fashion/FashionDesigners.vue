<script>
    import ApiService from "../../../components/api/api.service";
    export default {
        props:['companies'],
        data(){
            return{
                listCompanies: this.companies,
            }
        },
        methods:{
        },
        mounted() {
            console.log(this.listCompanies);
        }
    }
</script>
