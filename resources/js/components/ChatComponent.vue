<template>
<div id="frame">
    <div id="sidepanel">
        <comp-profile @del="clean"></comp-profile>

        <div id="search">
            <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
            <input type="text" placeholder="Search contacts..."/>
        </div>

        <div id="contacts">
            <ul id="listUser">
                <comp-user-list v-for="(user, index) in participants" :key="index" :user="user" :idToSend="idToSend" :pushdata="pusharr" @openChatNow="openChatViaID" :typeIndi="typingIndicator">
                </comp-user-list>
            </ul>
        </div>

        <comp-menu></comp-menu>
    </div>

    <comp-personal-chat :pushdata="pusharr" :id="id" :img="image" :name="name" @chatWith="chatWithID" @typeNow="listenType" :typeIndi="typingIndicator">
    </comp-personal-chat>

</div>
</template>

<script>

export default {
    data() {
        return {
            userlist: [],
            id: null,
            image: null,
            name: null,
            idLogged: null,
            pusharr: null,
            participants: [],
            toRemove: [],
            incomingMsgIcon: 'active',
            idToSend: null,
            activePeer: false,
            typingTimer: false,
            typingIndicator: null,
            whisperTyping: null,
            whisperReading: null
        }
    },
    computed: {
        channel() {
            return window.Echo.join('online')
        }
    },
    created() {
        var vue = this

        this.channel
            .here(users => {
                var notMe = __.without(users, __.findWhere(users, {
                    id: window.App.user.id
                }))
                this.participants = notMe
            })
            .joining(user => this.participants.push(user))
            .leaving(user => {
                this.participants.splice(this.participants.indexOf(user), 1)
                this.id = null
            })
            .listen('OnlineStatus', function (e) {
                if (e.type == 'clean') {
                    location.reload()
                } else {
                    vue.pusharr = e.pushchat
                }
            })
            .listenForWhisper('typing', this.whisperAction);
    },
    mounted() {
        this.getUserList()
        this.idLogged = window.App.user.id
    },
    methods: {
        listenType(typingID, typingWithID) {
            var datax = [typingID, window.App.user.name, typingWithID, 'show'];
            this.channel.whisper('typing', datax)
        },
        whisperAction(e) {
            var dataWhisper = [e[0], window.App.user.name, e[2], 'hide'];

            this.typingIndicator = e;
            if (this.typingTimer) clearTimeout(this.typingTimer)
            this.typingTimer = setTimeout(() => this.typingIndicator = dataWhisper, 1000)
        },
        clean() {
            axios.get('/delete')
                .then((response) => {
                    location.reload()
                })
                .catch((error) => {
                    toastr.error("Error when delete data. Please reload page manual")
                })
        },
        openChatViaID(id, image, name) {
            this.id = id,
            this.image = image
            this.name = name
        },
        chatWithID(sentid) {
            this.idToSend = sentid
        },
        getUserList() {
            const userID = window.App.user.id

            axios.get('/api/user/online/' + userID)
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
