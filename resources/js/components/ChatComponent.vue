<template>
<div id="frame">
    <div id="sidepanel">
        <comp-profile></comp-profile>

        <div id="search">
            <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
            <input type="text" placeholder="Search contacts..."/>
        </div>

        <div id="contacts">
            <ul id="listUser">
                <comp-user-list v-for="(user, index) in userlist" :key="index" :user="user"></comp-user-list>
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
            inviteUserStatus: false,
            group_name: '',
            tmpUserList: null
        }
    },
    watch: {
        getUserList: function() {
            this.userlist = this.getUserList
        },
        getOnlineTrigger: function() {
            const tUserList = this.tmpUserList
            _.forEach(tUserList, function(value, key) {
                $("span#"+value.id).removeClass("busy").addClass("online")
            });
        },
    },
    computed: {
        ...mapGetters([
            "getUserList",
            "getOnlineTrigger",
        ]),
        channel() {
            return window.Echo.join('online')
        },
    },
    created() {
        this.userListApi()
    },
    mounted() {
        this.idLogged = window.App.user.id
        this.setPersonalData(window.App.user)
        var self = this
        this.channel
            .here(users => {
                this.tmpUserList = users
                if(!_.isEmpty(users)) {
                    _.forEach(users, function(value, key) {
                        $("span#"+value.id).removeClass("busy").addClass("online")
                    });
                }
            })
            .joining(user => {
                $("span#"+user.id).removeClass("busy").addClass("online")
            })
            .leaving(user => {
                $("span#"+user.id).removeClass("online").addClass("busy")
            })
            .listen('IncomingChat', function (e) {
                var chat = e.pushchat
                if (e.type == 'clean') {
                    location.reload()
                } else {
                    self.$store.dispatch('newChatReceive', chat)
                }
            })
            .listenForWhisper('typing', this.whisperAction);
    },
    methods: {
        ...mapActions([
            "setPersonalData",
            "userListApi",
            "userMessageCount",
        ]),
        showModal() {
            this.$refs['modal-invite'].show()
        },
        hideModal() {
            this.$refs['modal-invite'].hide()
        },
        changePicture() {

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