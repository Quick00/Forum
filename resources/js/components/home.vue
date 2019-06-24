<template>
    <div class="homecontainer">
        <div class="titlethread">Home</div>
        <div class="loading" v-if="loading"></div>
        <div class="addtopic" v-if="addtopic">
            <h3>Maak hier een topic aan</h3>
            <img :src="'./img/' + 'backward.png'" @click="backfromadd">
            <form @submit.prevent="submittopic()">
                <input type="text" v-model="nametopic" placeholder="Het onderwerp van uw Topic">
                <textarea @keyup.enter="submittopic" class="description" placeholder="Vul hier uw vraag over het topic in" v-model="descriptiontopic"></textarea>
                <input type="submit" value="Submit">
            </form>
        </div>
        <div class="threadcontainer" v-if="!loading">
            <img :src="'./img/' + 'backward.png'" v-if="clicked > 1" @click="back()" class="back">
            <img :src="'./img/' + 'plus.png'" v-if="clicked == 2 && isLoggedIn" @click="makenewtopic()" class="plus">
            <ul>
                <li v-for="thread in threads" :key="thread.id" class="threads" @click="gotothread(thread)" v-if="clicked == 1">
                    <div class="threadname">{{thread.name}}</div>
                    <div class="threaddescription">{{thread.description}}</div>
                </li>
                <li v-for="topic in topics" :key="topic.id" v-if="clicked == 2" class="topics" @click="gototopic(topic)">
                    <div>{{ topic.name }}</div>
                </li>
                <li v-for="disscusion in disscusions" :key="disscusion.id" v-if="clicked == 3">
                    <div class="topictitle">{{ disscusion.name }}</div>
                    <div class="topicinfo">
                        <div class="inhoud">{{ disscusion.info }}</div> <br>
                        <input type="text" class="comment" placeholder="Plaats hier je reactie" @keyup.enter="placecomment(disscusion)" v-model="comment"> <br>
                        <div class="comments" v-for="comment in comments">
                            <p class="user">{{ comment.name }}</p>
                            <p>{{ comment.comment }}</p>
                        </div>
                    </div>
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
                comment: '',
                nametopic: '',
                descriptiontopic: '',
                addtopic: false,
                loading: false,
                canadd: false,
                save: 0,
                threads: [],
                comments: [],
                users: [],
                topics: [],
                disscusions: [],
                isLoggedIn: localStorage.getItem('Forum.jwt') != null,
                user: localStorage.getItem('Forum.user_ID'),

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
                this.save = thread.id
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

            gototopic(topic){
                this.loading = true
                let id = topic.id
                axios.post('api/topic', {id}).then(response => {
                    this.disscusions = response.data
                    this.clicked = 3
                    if(this.clicked > 1 && this.isLoggedIn == true){
                        this.canadd = true
                    }
                });
                axios.post('api/getcomment', {id}).then(response =>{
                    this.comments = response.data
                    this.loading = false
                    this.getuser()
                });

            },

             getuser(){
                let user_ID = this.comments.user_ID
                axios.post('api/getuser', {user_ID}).then(response =>{
                    this.users = response.data
                })
            },

            submittopic(){
                let thread_ID = this.save
                let id = this.save
                let user_ID = this.user
                let info = this.descriptiontopic
                let name = this.nametopic
                axios.post('api/maketopic', {thread_ID, user_ID, name, info})
                this.addtopic = false
                this.descriptiontopic = ''
                this.nametopic = ''
                axios.post('api/topics', {id}).then(response => {
                    this.topics = response.data
                    this.clicked = 2
                    this.loading = false
                    if(this.clicked == 2 && this.isLoggedIn == true){
                        this.canadd = true
                    }

                });

            },

            placecomment(disscusion){
                let topics_ID = disscusion.id
                let id = disscusion.id
                let comment = this.comment
                let user_ID = this.user
                axios.post('api/comment', {topics_ID, comment, user_ID}).then(response =>{
                    this.comments = response.data
                    this.comment = ''
                });
                axios.post('api/getcomment', {id}).then(response =>{
                    this.comments = response.data
                })

            },

            backfromadd(){
                this.addtopic = false
            },

            back(){
                this.clicked = this.clicked - 1
                if(this.clicked == 1){
                    this.topics = ''
                    this.save = 0
                }
                if(this.clicked == 1){
                    this.canadd = false
                }
                this.disscusion = ''
                this.comments = ''
            },

            makenewtopic(){
                    this.addtopic = true
            }


        }
    }
</script>
