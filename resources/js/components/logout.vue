<template>

</template>

<script>
    export default {
        name: "logout",
        mounted() {
            this.logout()
       },

       methods: {
            setDefaults() {
                if (this.isLoggedIn) {
                    let user = JSON.parse(localStorage.getItem('Forum.user'))
                    this.name = user.name
                    this.user_type = user.is_admin
                }
            },
            change() {
                this.isLoggedIn = localStorage.getItem('Forum.jwt') != null
                this.setDefaults()
            },
            logout(){
                localStorage.removeItem('Forum.jwt')
                localStorage.removeItem('Forum.user')
                this.change()
                this.$router.push('/')
            }
       }
    }
</script>

<style scoped>

</style>