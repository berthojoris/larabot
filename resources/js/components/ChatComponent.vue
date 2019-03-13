<template>
<div id="frame">
    <div id="sidepanel">
        <comp-profile></comp-profile>
        
        <comp-search></comp-search>
        
        <div id="contacts">
            <ul>
                <comp-user-list 
                    v-for="(user, index) in userlist" 
                    :key="index" 
                    :user="user" 
                    @openChatNow="openChatViaID">
                </comp-user-list>
            </ul>
        </div>
        
        <comp-menu></comp-menu>
    </div>

    <comp-personal-chat :pushdata="pusharr" :id="id" :img="image" :name="name"></comp-personal-chat>
</div>
</template>

<script>
export default {
    data() {
        return {
            userlist : [],
            id: null,
            image: null,
            name: null,
            idLogged: null,
            pusharr: null,
            participants: []
        }
    },
    computed: {
        channel() {
            return window.Echo.join('online')
        }
    },
    mounted() {
        this.getUserList()
        this.idLogged = window.App.user.id

        const vue = this

        this.channel
            .here(users => this.participants = users)
            .joining(user => this.participants.push(user))
            .leaving(user => this.participants.splice(this.participants.indexOf(user), 1))
            .listen('OnlineStatus', function (e) {
                vue.pusharr = e.pushchat
            })
    },
    methods: {
        filtered(arr) {
            var check = _.remove(arr, function(data) {
                return data.id == this.idLogged;
            });
        },
        openChatViaID(id, image, name) {
            this.id = id,
            this.image = image
            this.name = name
        },
        getUserList() {
            const userID = window.App.user.id

            axios.get('/api/user/online/'+userID)
            .then((response) => {
                this.userlist = response.data
            })
            .catch((error) => {
                console.log(error);
            });
        }
    }
}
</script>

<style scoped>

</style>
