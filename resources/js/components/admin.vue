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
                        <h4>{{user.name}}</h4>
                    </li>
                </ul>
        </div>
        <div class="threadaddcontainer">
            <h3>Topics</h3>
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
            }
        },

        created(){
            this.loading = true
            axios.get('api/user').then(response => {
                this.users = response.data
                this.loading = false
            })
        },

        methods: {
            addthread(){
                axios.post('api/threads' , {name: this.name, description: this.info})
                this.name = ''
                this.info = ''
            }
        }
    }
</script>

<style scoped>

</style>