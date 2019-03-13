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

    <comp-personal-chat :coba="pusharr" :id="id" :img="image" :name="name"></comp-personal-chat>
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
            pusharr: null
        }
    },
    mounted() {
        this.getUserList()
        this.idLogged = $("meta[name=user-id]").attr("content")
        var vue = this
        window.Echo.channel('pushchat').listen('IncomingChat', function (e) {
            let dataChat = e.pushchat
            vue.pusharr = dataChat
        })
    },
    methods: {
        openChatViaID(id, image, name) {
            this.id = id,
            this.image = image
            this.name = name
        },
        getUserList() {
            const userID = $("meta[name=user-id]").attr("content")

            axios.get('/api/user/online/'+userID)
            .then((response) => {
                let listUserDB = response.data
                this.userlist = listUserDB
            })
            .catch((error) => {
                console.log(error);
            });
        }
    }
}
</script>

<style scoped>
body {
    overflow-y:hidden;
}
</style>
