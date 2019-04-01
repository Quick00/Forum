<template>
    <v-content>
    <header>
        <nav class="navbar">
            <img :src="'./img/' + 'Logo.png'">
            <h4>Forum</h4>
            <ul class="navtext">
                <li><p><router-link to="/">Home</router-link></p></li>
                <li v-if="!isLoggedIn"><p><router-link to="/register">Registreren</router-link></p></li>
                <li v-if="!isLoggedIn"><p><router-link to="/login">Login</router-link></p></li>
                <li v-if="admin"><p><router-link to="/admin">Admin</router-link></p></li>
                <li v-if="isLoggedIn" @click="logout"><p><router-link to="/logout">Logout</router-link></p></li> 
            </ul>
        </nav>
    </header>
    <router-view @loggedIn="change"></router-view>
    </v-content>
</template>

<script>
    export default {
        name: "main",
        data(){
            return{
                user_type: 0,
                admin: 0,
                isLoggedIn: localStorage.getItem('Forum.jwt') != null,
                clicked: 1,
            }
        },

        created() {
            this.change()
        },
    
        methods : {
            setDefaults() {
                if (this.isLoggedIn) {
                    let user = JSON.parse(localStorage.getItem('Forum.user'))
                    this.name = user.name
                    this.user_type = user.is_admin
                }else{
                    this.name = ''
                    this.user_type = 0
                }
            },
            change() {
                this.isLoggedIn = localStorage.getItem('Forum.jwt') != null
                this.setDefaults()
                if(this.user_type === 1){
                    this.admin = true
                }else{
                    this.admin = false
                }

            },
            logout(){
                localStorage.removeItem('Forum.jwt')
                localStorage.removeItem('Forum.user')
                this.change()
                this.$router.push('/')

            },
        }

    }
</script>

<style scoped>

</style>