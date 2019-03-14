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
        <img :src="img">
        <p>{{ name }}</p>
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
            <input type="text" @keyup.enter="sendMessage" v-model="messagetext" placeholder="Write your message..." />
            <i class="fa fa-paperclip attachment" aria-hidden="true"></i>
            <button @click="sendMessage" class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ['id', 'img', 'name', 'pushdata'],
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
            userOpenedChat: null
        }
    },
    mounted() {
        this.getRandomChat()
        this.idLogged = window.App.user.id
    },
    watch: {
        id: function(val) {
            this.getChatList(val)
        },
        pushdata: function(val) {
            if(!_.isEmpty(val)) {
                if(this.alreadyOpen) {
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
            if(!_.isEmpty(this.chats)) {
                this.$nextTick(() => {
                    VueScrollTo.scrollTo("div.messages ul li:last-child", 0, {
                        container: '.messages'
                    })
                })
            }
        }
    },
    methods: {
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
            this.whenChatReady()

            $("span#"+this.id).removeClass().addClass('contact-status online')

            const picture = window.App.user.image

            this.chats.push({
                sender_id: this.idLogged,
                sender_image: picture,
                receive_image: '',
                type: 'sent',
                message: this.messagetext
            })

            if(!_.isEmpty(this.chats)) {
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
            var str = RandomWords({ exactly: 15, join: ' ' })
            return str.charAt(0).toUpperCase() + str.slice(1)
        },
        getChatList(receiverID) {
            const userID = window.App.user.id
            this.chats = []

            this.$emit('chatWith', receiverID)

            this.whenLoading()

            axios.get('/api/chat/list/'+userID+'/'+receiverID)
            .then((response) => {
                this.loadStatus = false
                let chatDB = response.data
                this.chats = chatDB

                if(!_.isEmpty(this.chats)) {
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
            .then(function() {
                
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
            })
            .catch((error) => {
                this.getRandomChat()
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
</style>
