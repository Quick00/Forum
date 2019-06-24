<template>
    <div>
        <div class="threadaddcontainer">
            <h3>Maak een thread</h3>
            <form @submit.prevent="addthread">
                <input type="text" class="name" placeholder="Name" v-model="name" required>
                <input type="text" class="username" placeholder="Desciption" v-model="info" required>
                <input type="submit" class="submit" value="Submit">
            </form>
        </div>
        <div class="threadaddcontainer">
            <h3>Users</h3>
            <div class="loading" v-if="loading"></div>
                <ul v-for="user in users" :key="user.id">
                    <li>
                        <img :src="'./img/delete.png'" class="imgtopics" @click="deleteuser(user)">
                        <h4>{{user.name}}</h4>
                    </li>
                </ul>
        </div>
        <div class="threadaddcontainer">
            <h3>Topics</h3>
            <ul v-for="topic in topics" :key="topic.id">
                <li>
                    <img :src="'./img/delete.png'" class="imgtopics" @click="deletetopic(topic)">
                    <h4>{{topic.name}}</h4>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: "admin",
        data(){
            return{
                name: '',
                loading: false,
                info: '',
                users: [],
                topics:[],
            }
        },

        created(){
            this.loading = true
            axios.get('api/user').then(response => {
                this.users = response.data
                this.loading = false
            })
            axios.get('api/showtopic').then(response => {
                this.topics = response.data
            })
        },

        methods: {
            addthread(){
                axios.post('api/threads' , {name: this.name, description: this.info})
                this.name = ''
                this.info = ''
            },

            deleteuser(user){
                axios.delete('./api/user/' + user.id)
                axios.get('api/user').then(response => {
                    this.users = response.data
                    this.loading = false
                })
            },

            deletetopic(topic){
                axios.delete('./api/topic/' + topic.id)
                axios.delete('./api/deletecomment/' + topic.id)
                axios.get('api/showtopic').then(response => {
                    this.topics = response.data
                })
            }
        }
    }
</script>

<style scoped>

</style>