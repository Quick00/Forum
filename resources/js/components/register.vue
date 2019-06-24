<template>
     <main>
        <div class="logincontainer">
            <h4>Register</h4>
            <form >
                <input type="text" class="name" placeholder="Name" v-model="name" required>
                <input type="email" class="username" placeholder="Email" v-model="email" required>
                <input type="password" class="password" placeholder="Password" v-model="password" required>
                <input type="password" class="c_password" placeholder="Check your password" v-model="c_password" required>
                <input type="submit" class="submit" value="Submit" @click="register">
            </form>
        </div>
    </main>
</template>

<script>
    import axios from 'axios'
    import Routes from  '@/js/routes.js';
    export default {
        name: "register",

        data() {
                return {
                    name: "",
                    email: "",
                    password: "",
                    c_password: "",
                    user: '',
                    isLoggedIn: localStorage.getItem('Forum.jwt') != null
                }
            },

            created(){
                if(this.isLoggedIn === true){
                    this.$router.push('/')
                }
            },

        methods: {
            register(e){
                e.preventDefault()
                if(this.password !== this.c_password || this.password.length <= 0){
                    this.password = ""
                    this.c_password = ""
                    return alert('password do not match')
                }

                let name = this.name
                let email = this.email
                let password = this.password
                let c_password = this.c_password

                axios.post('api/register', {name, email, password, c_password}).then(response =>{
                    let data = response.data
                    let user_ID = data.user.id
                    localStorage.setItem('Forum.user_ID', user_ID)
                    localStorage.setItem('Forum.user' , JSON.stringify(data.user))
                    localStorage.setItem('Forum.jwt', data.token)
                    if(localStorage.getItem('Forum.jwt') != null){
                        this.$emit('loggedIn')
                        let nextUrl = this.$route.params.nextUrl
                        this.$router.push((nextUrl != null ? nextUrl : '/'))
                    }
                })


            }
        },
    }
</script>

<style scoped>

</style>