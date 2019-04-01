<template>
    <div class="homecontainer">
        <div class="titlethread">Home</div>
        <div class="loading" v-if="loading"></div>
        <div class="threadcontainer" v-if="!loading">
            <img :src="'./img/' + 'backward.png'" v-if="clicked == 2" @click="back()" class="back">
            <img :src="'./img/' + 'plus.png'" v-if="canadd" @click="makenewtopic()" class="plus">
            <ul>
                <li v-for="thread in threads" :key="thread.id" class="threads" @click="gotothread(thread)" v-if="clicked == 1">
                    <div class="threadname">{{thread.name}}</div>
                    <div class="threaddescription">{{thread.description}}</div>
                </li>
                <li v-for="topic in topics" :key="topic.id" v-if="clicked == 2" class="topics">
                    <div>{{ topic.name }}</div>
                    <div>{{ topic.info }}</div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: "home",


        data(){
            return{
                clicked: 1,
                loading: false,
                canadd: false,
                threads: [],
                topics: [],
                isLoggedIn: localStorage.getItem('Forum.jwt') != null,

            }
        },

        created(){
            this.loading = true
            axios.get('api/threads').then(response => {
                this.threads = response.data
                this.loading = false
            })
            if(this.clicked == 2 && this.isLoggedIn == true){
                canadd = true
            }

        },

        methods: {

            gotothread(thread){
                this.loading = true
                let id = thread.id
                axios.post('api/topics', {id}).then(response => {
                    this.topics = response.data
                    this.clicked = 2
                    this.loading = false
                    if(this.clicked == 2 && this.isLoggedIn == true){
                        this.canadd = true
                    }

                });

            },

            back(){
                this.clicked = this.clicked - 1
                this.topics = ''
                this.canadd = false
            },


        }
    }
</script>

<style scoped>

</style>