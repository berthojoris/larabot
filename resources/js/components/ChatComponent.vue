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

        <div id="bottom-bar">
            <button id="createGroupChat"
                @click="showModal">
                <i class="fa fa-user-plus fa-fw" aria-hidden="true"></i>
                Group Invite
            </button>
            <button id="accountSetting">
                <i class="fa fa-cog fa-fw" aria-hidden="true"></i> 
                <span>Settings</span>
            </button>
        </div>
    </div>

    <comp-personal-chat :pushdata="pusharr" :id="id" :img="image" :name="name" @chatWith="chatWithID" @typeNow="listenType" :typeIndi="typingIndicator">
    </comp-personal-chat>

    <b-modal ref="my-modal" hide-footer title="Sent Invitation" @shown="focusMyElement">
        <b-form inline>
            <label class="sr-only" for="email">Email</label>
            <b-input-group prepend="@" class="mb-2 mr-sm-2 mb-sm-0">
                <b-input id="email" name="email" ref="email" placeholder="Invite by email" autocomplete="off"></b-input>
            </b-input-group>
            <b-button id="findUser" variant="info">Invite</b-button>
        </b-form>
    </b-modal>

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
        focusMyElement(e) {
            this.$refs.email.focus()
        },
        showModal() {
            this.$refs['my-modal'].show()
        },
        hideModal() {
            this.$refs['my-modal'].hide()
        },
        toggleModal() {
            // We pass the ID of the button that we want to return focus to
            // when the modal has hidden
            this.$refs['my-modal'].toggle('#toggle-btn')
        },
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

<style lang="scss">
@import 'node_modules/bootstrap/scss/bootstrap';
@import 'node_modules/bootstrap-vue/src/index.scss';
.modal-footer {
    padding: 7px;
}
.modal-header {
    padding: 10px;
}
.form-inline .input-group, .form-inline .custom-select {
    width: 84%;
}
</style>