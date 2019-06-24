<template>
    <main>
        <div class="logincontainer">
            <h4>Login</h4>
            <form >
                <input type="email" class="username" placeholder="Email" v-model="email" required>
                <input type="password" class="password" placeholder="Password" v-model="password" required >
                <input type="submit" class="submit" value="Submit" @click="Login">
            </form>
        </div>
    </main>
</template>

<script>
    import axios from 'axios'
    import Routes from  '@/js/routes.js';
    export default {
        name: "login",

        data() {
                return {
                    email: "",
                    password: "",
                    isLoggedIn: localStorage.getItem('Forum.jwt') != null
                }
            },
            created(){
                    if(this.isLoggedIn === true){
                        this.$router.push('/') 
                    }
                },
        methods: {
               Login(e) {
                    e.preventDefault()
                    if (this.password.length > 0) {
                        let email = this.email
                        let password = this.password

                        axios.post('api/login', {email, password}).then(response => {
                            let user = response.data.user
                            let user_ID = user.id
                            let is_admin = user.is_admin

                            localStorage.setItem('Forum.user', JSON.stringify(user))
                            localStorage.setItem('Forum.jwt', response.data.token)
                            localStorage.setItem('Forum.user_ID' , user_ID)

                            if (localStorage.getItem('Forum.jwt') != null) {
                                this.$emit('loggedIn')
                                if (this.$route.params.nextUrl != null) {
                                    this.$router.push(this.$route.params.nextUrl)
                                } else {
                                    this.$router.push((is_admin == 1 ? 'admin' : '/'))
                                }
                            }
                        });
                    }
                },
        },    
    }
</script>

<style scoped>

</style>