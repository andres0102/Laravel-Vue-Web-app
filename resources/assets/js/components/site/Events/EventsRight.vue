<template>
    <div class="items">
        <h2 class="title">Upcoming Events</h2>
        <div class="upcoming-event-card col-12 mb-2" v-for="n in 5">
            <div class="event-wrapper row">
                <div class="image-header col-md-3">
                    <a href="#">
                        <img src='/assets/img/events/events-img1.jpeg' />
                    </a>
                </div>
                <div class="content col-md-9">
                    <div class="header">
                                                <span class="title">
                                                    FLORENCE + THE MACHINE
                                                    <span class="time">8pm</span>
                                                </span>
                        <span class="additional-title">
                                                    Cold War Kids
                                                    <span class="time">7pm</span>
                                                </span>
                    </div>
                    <div class="footer">
                        <div class="date">
                                                    <span class="text">
                                                        OCT <span>23</span>
                                                    </span>
                        </div>
                        <div class="description">
                            <p class="text">This event is 21 and over</p>
                            <a href="#"><span></span>More Info</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    const layoutTypes = {
        CARDS: 'cards',
        LIST: 'list'
    };

    export default {
        props: {
            data: Object,
            layoutList: Boolean,
            largeCards: Boolean,
            items: Object,
        },

        data() {
            return {
                titleClass: '',
                descriptionClass: '',
                layoutType: layoutTypes.CARDS
            }
        },

        mounted() {
            if (this.data !== undefined) {
                this.titleClass = this.data.titleClass || '';
                this.descriptionClass = this.data.descriptionClass || '';
            }
            if (this.layoutList !== undefined && this.layoutList === true) {
                this.layoutType = layoutTypes.LIST;
            }
        },

        computed: {
            layoutClass: function () {
                return {
                    'events_list': this.layoutType === layoutTypes.LIST,
                    'events_card': this.layoutType === layoutTypes.CARDS,
                    'events_large': this.largeCards !== undefined && this.largeCards === true
                }
            },
            itemsCount: function () {
                if (this.largeCards !== undefined && this.largeCards === true) {
                    return 3;
                } else {
                    return 4;
                }
            }
        },

        methods: {

        }
    }
</script>

<style lang="scss">

    .custom-section .section-header .content {
        font-size: 1.1rem;
    }

    .events {
        display: flex;
        flex-flow: column nowrap;
        justify-content: space-between;
        align-items: center;
        &_card {
            margin: 0;
            @media (min-width: 768px) {
                flex-flow: row nowrap;
                margin: 0 -1rem;
            }
            .events__item {
                flex: 0 1 25%;
                @media (min-width: 768px) {
                    margin: 0 0.5rem 1.5rem 0.5rem;
                }

            }
        }
        &_list {
            margin: -1rem 0;
            align-items: stretch;
            @media (min-width: 768px) {
            }
            .events__item {
                display: flex;
                flex-flow: column nowrap;
                @media (min-width: 768px) {
                    flex-flow: row nowrap;
                    margin: 0.5rem 0;
                }
                .image-header {
                    img {
                        border-bottom-left-radius: 0;
                        @media (min-width: 768px) {
                            height: 100%;
                            max-width: 240px;
                            border-top-right-radius: 0;
                            border-top-left-radius: 6px;
                            border-bottom-left-radius: 6px;
                        }
                    }
                }
                .content {
                    flex-grow: 1;
                    display: flex;
                    flex-flow: column nowrap;
                    align-items: stretch;
                    .header {
                        flex: 1 0 40%;
                        h2 {
                            font-size: 1.5rem;
                            text-transform: uppercase;
                        }
                        h3 {
                            font-size: 1.2rem;
                        }
                    }
                    .footer {
                        flex: 1 0 60%;
                    }
                }
                .more {
                    @media (min-width: 768px) {
                        padding: 10px 20px;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }
                }
            }
        }
        &_large {
            .events__item {
                flex: 0 1 33%;
                padding: 20px;
            }
        }

        &__item {
            box-shadow: 0px 0px 10px rgba(1, 1, 1, .5);
            border-radius: 6px;
            margin: 0 0 1.5rem 0;
            overflow: hidden;
            @media (min-width: 768px) {

            }
            .image-header {
                img {
                    width: 100%;
                }
            }
            .content {
                .header {
                    border-bottom: 1px solid rgb(185, 185, 185);
                    padding: 6px;

                    font-family: Barlow;

                    h2 {
                        font-size: 16px;

                        .time {
                            font-size: 14px;
                            color: grey;
                            margin-left: 3%;
                        }
                    }

                    h3 {
                        font-size: 13px;

                        time {
                            font-size: 12px;
                            color: grey;
                            margin-left: 3%;
                        }
                    }
                }

                .footer {
                    position: relative;

                    .date {
                        display: inline-flex;
                        border-right: 1px solid #dddcd7;
                        justify-content: center;
                        align-items: center;
                        width: 35%;
                        height: 75px;
                        padding-bottom: 12%;
                        padding-right: 2%;

                        .text {
                            color: #000000;
                            font-size: 21px;
                            font-family: 'DINCond-Medium';
                            position: relative;
                            width: 40px;

                            span {
                                display: inline-block;
                                font-size: 32px;
                                color: #c1060f;
                                font-family: 'DINCond-Bold';
                                position: absolute;
                                bottom: -29px;
                                padding-top: 6px;
                                right: -11px;

                                &:before {
                                    width: 1px;
                                    height: 30px;
                                    background: #c1060f;
                                    content: '';
                                    position: absolute;
                                    top: -10px;
                                    left: 0px;
                                    transform: rotate(50deg);
                                }
                            }
                        }
                    }

                    .description {
                        display: inline-flex;
                        -webkit-box-orient: vertical;
                        -webkit-box-direction: normal;
                        -ms-flex-direction: column;
                        flex-direction: column;
                        width: 60%;
                        padding-right: 6%;
                        padding-left: 6%;
                        position: absolute;
                        justify-content: center;
                        height: 100%;

                        .text {
                            margin-bottom: 0;
                            color: #989898;
                            font-size: 14px;
                            font-family: 'DINCond-Medium';
                            padding-bottom: 0px;
                        }

                        a {
                            color: #2c82d3;
                            font-size: 13px;
                            font-family: 'DINCond-Medium';
                            display: flex;
                            align-items: center;

                            // span {     
                            //     width: 16px;
                            //     height: 16px;
                            //     display: -webkit-inline-box;
                            //     display: -ms-inline-flexbox;
                            //     display: inline-flex;
                            //     -webkit-box-align: center;
                            //     -ms-flex-align: center;
                            //     align-items: center;
                            //     justify-content: center;
                            //     background: #0283ff;
                            //     color: white;
                            //     border-radius: 50%;
                            //     font-size: 24px;
                            //     padding-bottom: 3px;
                            //     font-family: BarlowLight;
                            //     margin-right: 3px;
                            // }
                            span {
                                background: #0283ff;
                                color: white;
                                font-size: 12px;
                                height: 1.5em;
                                width: 1.5em;
                                border-radius: 50%;
                                position: relative;
                                margin-right: 4px;
                                
                                &:after,
                                &:before {
                                    content: "";
                                    display: block;
                                    background-color: white;
                                    position: absolute;
                                    top: 50%;
                                    left: 50%;
                                    transform: translate(-50%, -50%);
                                }
                                
                                &:before {
                                    height: 1em;
                                    width: 0.25em;
                                }

                                &:after {
                                    height: 0.25em;
                                    width: 1em;
                                }
                            }
                        }
                    }
                }
            }

            .more {
                display: none;
                border-left: 1px solid rgb(185, 185, 185);
            }
        }
    }
</style>
