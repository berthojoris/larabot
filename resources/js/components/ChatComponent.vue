<template>
<div id="frame">
    <div id="sidepanel">
        <comp-profile @del="clean"></comp-profile>
        
        <comp-search></comp-search>
        
        <div id="contacts">
            <ul>
                <comp-user-list 
                    v-for="(user, index) in participants" 
                    :key="index" 
                    :user="user"
                    :idToSend="idToSend"
                    :pushdata="pusharr"
                    @openChatNow="openChatViaID">
                </comp-user-list>
            </ul>
        </div>
        
        <comp-menu></comp-menu>
    </div>

    <comp-personal-chat 
        :pushdata="pusharr" 
        :id="id"
        :img="image"
        :name="name"
        @chatWith="chatWithID">
    </comp-personal-chat>

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
            participants: [],
            toRemove: [],
            incomingMsgIcon: 'active',
            idToSend: null
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

         var vue = this

        this.channel
            .here(users => {
                var notMe = __.without(users, __.findWhere(users, {id: window.App.user.id}));
                this.participants = notMe
            })
            .joining(user => this.participants.push(user))
            .leaving(user => {
                this.participants.splice(this.participants.indexOf(user), 1)
                this.id = null
            })
            .listen('OnlineStatus', function (e) {
                if(e.type == 'clean') {
                    location.reload()
                } else {
                    vue.pusharr = e.pushchat
                }
            })
    },
    methods: {
        clean() {
            axios.get('/delete')
            .then((response) => {
                location.reload()
            })
            .catch((error) => {
                alert("Error delete data")
            })
        },
        openChatViaID(id, image, name) {
            this.id = id,
            this.image = image
            this.name = name
            console.log("SAMPE DI PARENT")
        },
        chatWithID(sentid) {
            this.idToSend = sentid
        },
        getUserList() {
            const userID = window.App.user.id

            axios.get('/api/user/online/'+userID)
            .then((response) => {
                this.userlist = response.data
            })
            .catch((error) => {
                console.log(error);
            })
        }
    }
}
</script>

<style scoped>

</style>
