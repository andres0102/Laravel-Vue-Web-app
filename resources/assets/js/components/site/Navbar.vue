<script>

    import AuthMenu from './AuthMenu.vue';

    const selects = {
        NAVIGATION: '.navigation'
    }

    const classes = {
        TOGGLE: 'toggle'
    }

    export default {
        props: ['data'],

        data() {
            return {
                isToogleNavbar: false,
                showVipBar: !this.$cookie.get('vipBox'),
            }
        },

        components: {
            AuthMenu,
        },

        mounted() {
        },
        
        methods: {
            toogleMenu: function(event) {
                this.isToogleNavbar = !this.isToogleNavbar;

                $(selects.NAVIGATION).slideToggle(700);			
                $(event.target).toggleClass(classes.TOGGLE);
            },
            hideVipBar() {
                this.$cookie.set("vipBox", false, { expires: '1M' });
                this.showVipBar = false;
            }
        }
    }
</script>