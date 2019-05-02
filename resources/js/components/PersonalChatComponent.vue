<template>
<div class="content">

    <div v-if="firstEmpty" class="centerText">
        <p>"Stay connected with people around you"</p>
    </div>

    <div v-if="emptyChat" class="circonf-wrapper centerText">
        <p>Sorry there is no chat history with this user</p>
    </div>

    <div class="item loading-5" v-if="loadStatus">
        <div class="svg-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em">
                <circle cx="0.6em" cy="0.6em" r="0.5em" class="circle"/>
            </svg>
        </div>
    </div>

    <div v-if="chats.length" class="contact-profile">
        <div>
            <img :src="img">
             <p class="normal">{{ name }}</p>
             <div class="typeIndicator showhide"> is Typing ...</div>
        </div>
        <div class="social-media">
            <i class="fa fa-facebook" aria-hidden="true"></i>
            <i class="fa fa-twitter" aria-hidden="true"></i>
            <i class="fa fa-instagram" aria-hidden="true"></i>
        </div>
    </div>
    <div v-if="chats.length" class="messages">
        <ul>
            <li v-for="(chat, index) in chats" :key="index" :class="{'sent': chat.sender_id == idLogged,  'replies': chat.sender_id != idLogged}">
                <img :src="chat.sender_image" v-if="chat.sender_id == idLogged">
                <img :src="chat.sender_image" v-if="chat.sender_id != idLogged">
                <p>{{ chat.message }}</p>
            </li>
        </ul>
    </div>
    <div v-if="typeChatHere" class="message-input">
        <div class="wrap">
            <input ref="writemsg" type="text" @keydown="tagPeers" @keyup.enter="sendMessage" v-model="messagetext" placeholder="Write your message..." />
            <i class="fa fa-paperclip attachment" aria-hidden="true"></i>
            <button @click="sendMessage" class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
        </div>
    </div>
</div>
</template>

<script>
import ErrorBag from '../ErrorBag'

export default {
    props: ['id', 'img', 'name', 'pushdata', 'typeIndi'],
    data() {
        return {
            messagetext: '',
            chats: [],
            loadStatus: false,
            emptyChat: false,
            idLogged: null,
            typeChatHere: false,
            firstEmpty: true,
            alreadyOpen: false,
            activePeer: false,
            errors: new ErrorBag
        }
    },
    mounted() {
        this.idLogged = window.App.user.id
        this.getRandomChat()
    },
    watch: {
        typeIndi: function() {
            if(this.typeIndi[3] == 'hide') {
                $(".typeIndicator").removeClass().addClass("typeIndicator showhide")
                $(".nameUp").removeClass().addClass("normal")
            } else {
                if(this.typeIndi[2] == window.App.user.id) {
                    $(".typeIndicator").removeClass().addClass("typeIndicator")
                    $(".normal").removeClass().addClass("nameUp")
                }
            }
        },
        id: function (val) {
            this.getChatList(val)
        },
        pushdata: function (val) {
            if (!_.isEmpty(val)) {
                if (this.alreadyOpen) {
                    this.whenChatReady()

                    this.chats.push({
                        sender_id: val.sender_id,
                        sender_image: val.sender.image,
                        receive_image: val.receive.image,
                        type: 'replies',
                        message: val.message
                    })
                }
            } else {
                this.chats = []
                this.whenFirstInit()
            }
            if (!_.isEmpty(this.chats)) {
                this.$nextTick(() => {
                    VueScrollTo.scrollTo("div.messages ul li:last-child", 0, {
                        container: '.messages'
                    })
                })
            }
            this.getRandomChat()
        }
    },
    methods: {
        tagPeers() {
            this.$emit('typeNow', window.App.user.id, this.id)
        },
        whenFirstInit() {
            this.firstEmpty = true
            this.emptyChat = false
            this.typeChatHere = true
            this.loadStatus = false
            this.alreadyOpen = false
            this.$nextTick(() => {
                $("div.wrap span.contact-status").removeClass().addClass('contact-status online')
            })
        },
        whenLoading() {
            this.firstEmpty = false
            this.emptyChat = false
            this.typeChatHere = false
            this.loadStatus = true
            this.alreadyOpen = true
        },
        whenNoChat() {
            this.firstEmpty = false
            this.loadStatus = false
            this.emptyChat = true
            this.typeChatHere = true
            this.alreadyOpen = true
        },
        whenChatReady() {
            this.firstEmpty = false
            this.loadStatus = false
            this.emptyChat = false
            this.typeChatHere = true
            this.alreadyOpen = true
        },
        sendMessage() {
            if (this.messagetext.trim().length < 1) return;

            if(this.id == null) {
                toastr.warning("Select the user before starting the conversation")
                return
            }

            this.whenChatReady()

            const picture = window.App.user.image

            this.chats.push({
                sender_id: this.idLogged,
                sender_image: picture,
                receive_image: '',
                type: 'sent',
                message: this.messagetext
            })

            if (!_.isEmpty(this.chats)) {

                if (this.messagetext.length > 10) {
                    var limitStr = this.messagetext.substring(0, 32) + " ..."
                } else {
                    var limitStr = this.messagetext
                }

                $("div.meta").find("p#" + this.id).empty().html(limitStr)
                this.$nextTick(() => {
                    VueScrollTo.scrollTo("div.messages ul li:last-child", 0, {
                        container: '.messages'
                    })
                })
            }
            this.saveChatToDB()
        },
        getRandomChat() {
            this.messagetext = this.upperFirst()
        },
        upperFirst() {
            var str = RandomWords({
                exactly: 10,
                join: ' '
            })
            return str.charAt(0).toUpperCase() + str.slice(1)
        },
        getChatList(receiverID) {
            const userID = window.App.user.id
            this.chats = []

            this.$emit('chatWith', receiverID)

            this.whenLoading()

            axios.get('/api/chat/list/' + userID + '/' + receiverID)
                .then((response) => {
                    this.loadStatus = false
                    let chatDB = response.data
                    this.chats = chatDB

                    if (!_.isEmpty(this.chats)) {
                        this.whenChatReady()
                        this.$nextTick(() => {
                            VueScrollTo.scrollTo("div.messages ul li:last-child", 0, {
                                container: '.messages'
                            })
                        })
                    } else {
                        this.whenNoChat()
                    }
                })
                .catch((error) => {
                    this.whenNoChat()
                })
                .then(function () {

                });
        },
        saveChatToDB() {
            const userID = window.App.user.id
            axios.post('/api/chat/insert', {
                message: this.messagetext,
                sender_id: userID,
                receive_id: this.id
            })
            .then((response) => {
                this.getRandomChat()
                this.errors.clearAll()
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    const errorsCollection = error.response.data.errors
                    this.errors.setErrors(errorsCollection)
                    toastr.error(this.errors.first('message'))
                }
            });
        }
    }
}
</script>

<style scoped>
.center {
    margin-top: 40%;
    margin-left: 20%;
    width: 60%;
    border: 3px solid #73AD21;
    padding: 10px;
    text-align: center;
}

.centerText {
    margin-top: 40%;
    font-size: 25px;
    width: 100%;
    text-align: center;
}
.typeIndicator {
    position: absolute; 
    left: 62px; 
    top: 11px; 
    font-size: 12px;
}
.nameUp {
    margin-top: -5px;
}
.showhide {
    display: none;
}
</style>
