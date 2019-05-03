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
                <comp-user-list v-for="(user, index) in userlist" :key="index" :user="user" :typeIndi="typingIndicator">
                </comp-user-list>
            </ul>
        </div>

        <div id="bottom-bar">
            <button id="createGroupChat"
                @click="showModal">
                <i class="fa fa-user-plus fa-fw" aria-hidden="true"></i>
                Create Group
            </button>
            <button id="accountSetting">
                <i class="fa fa-cog fa-fw" aria-hidden="true"></i> 
                <span>Add Friends</span>
            </button>
        </div>
    </div>

    <comp-personal-chat></comp-personal-chat>

    <b-modal ref="modal-invite" hide-footer title="Sent Invitation" :no-close-on-esc="true" :no-close-on-backdrop="true">
        <b-form-group id="group_create_group">
            <b-input-group>
                <b-input-group-text slot="prepend">Group Name</b-input-group-text>
                <b-form-input v-model="group_name"></b-form-input>
                <b-button id="createGroup" variant="info" @click="createGroup()">Create</b-button>
            </b-input-group>
        </b-form-group>

        <b-form-group id="group_invitation" v-if=inviteUserStatus>
            <b-input-group>
                <b-input-group-text slot="prepend">@</b-input-group-text>
                <b-form-input v-model="email_user"></b-form-input>
                <b-button id="inviteUser" rel="inviteUser" variant="info">Invite</b-button>
            </b-input-group>
        </b-form-group>
    </b-modal>

    <b-modal ref="modal-invite-question" hide-footer title="Accept / Reject Invitation">
        <div class="mt-12">
            <b-card-group deck>
                <b-card bg-variant="light" header="Light" class="text-center">
                    <b-card-text>Invitation coming from "User"</b-card-text>
                </b-card>
            </b-card-group>
        </div>
    </b-modal>

</div>
</template>

<script>
import {mapGetters, mapActions} from "vuex"
export default {
    data() {
        return {
            userlist: [],
            // id: null,
            // image: null,
            // name: null,
            // idLogged: null,
            // pusharr: null,
            // participants: [],
            // toRemove: [],
            // incomingMsgIcon: 'active',
            // idToSend: null,
            // activePeer: false,
            // typingTimer: false,
            typingIndicator: null,
            // whisperTyping: null,
            // whisperReading: null,
            inviteUserStatus: false,
            group_name: ''
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
            // .here(users => {
            //     var notMe = __.without(users, __.findWhere(users, {
            //         id: window.App.user.id
            //     }))
            //     this.participants = notMe
            // })
            .joining(user => {
                console.log("JOIN");
                console.log(user);
            })
            .leaving(user => {
                console.log("LEAVE");
                console.log(user);
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
        this.setPersonalData(window.App.user)
    },
    methods: {
        ...mapActions([
            "setPersonalData"
        ]),
        showModal() {
            this.$refs['modal-invite'].show()
        },
        hideModal() {
            this.$refs['modal-invite'].hide()
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
        getUserList() {
            const userID = window.App.user.id

            axios.get('/api/user/online/' + userID)
                .then((response) => {
                    this.userlist = response.data
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        createGroup() {
            if (this.group_name.trim().length < 1) return;
            var nama = this.group_name
            axios.post('/group/create', {
                group_name: nama,
            }).then((response) => {
                if(response.status == 201) {
                    this.group_name = ''
                }
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
</style>