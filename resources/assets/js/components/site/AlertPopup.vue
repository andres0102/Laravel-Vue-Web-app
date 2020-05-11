<script>
    export default{
        props:["message","show","shclass" ,'type'],
        data(){
                return {
                }
            },
        mounted(){
        },
        methods: {

        },



    }
</script>

<template id="alert">
    <div :class="{'alert':true, 'alert-show': shclass, 'alert-close': !shclass, 'alert-success': type , 'alert-danger': !type}" v-show="show">
        <div>{{message }}</div>
    </div>
</template>
<style>
    .alert {
        text-align: center;
        position: fixed;
        width: 100%;
        padding: 20px;
        z-index: 9999;
        left: 0;
        /* transition */
        -webkit-transition: all  0.5s;
        -moz-transition: all  0.5s;
        -o-transition: all 0.5s;
        transition: all 0.5s;
    }
    .alert-show{
        top:0px;
        -webkit-transition: all  0.5s;
        -moz-transition: all  0.5s;
        -o-transition: all 0.5s;
        transition: all 0.5s;
    }
    .alert-close{
        top: -100px;
        -webkit-transition: all  0.5s;
        -moz-transition: all  0.5s;
        -o-transition: all 0.5s;
        transition: all 0.5s;
    }

</style>
