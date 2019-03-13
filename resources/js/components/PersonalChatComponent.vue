<template>
<div class="content">

    <div v-if="emptyChat" class="circonf-wrapper center">
        <h3>Sorry there is no chat history with this user</h3>
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
                <img :src="chat.sender_image" v-if="chat.sender_id == idLogged" hasil="sama">
                <img :src="chat.sender_image" v-if="chat.sender_id != idLogged" hasil="tidak sama">
                <p>{{ chat.message }}</p>
            </li>
        </ul>
    </div>
    <div v-if="showChatText" class="message-input">
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
    props: ['id', 'img', 'name'],
    data() {
        return {
            messagetext: '',
            chats: [],
            loadStatus: false,
            emptyChat: false,
            idLogged: null,
            showChatText: false
        }
    },
    mounted() {
        this.idLogged = $("meta[name=user-id]").attr("content")
    },
    watch: {
        id: function(val) {
            this.getChatList(val)
        }
    },
    methods: {
        sendMessage() {
            if (this.messagetext.trim().length < 1) return;
            const picture = $("meta[name=user-profile-pic]").attr("content")
            this.chats.push({
                sender_id: this.idLogged,
                sender_image: picture,
                receive_image: '',
                type: 'sent',
                message: this.messagetext
            })
            this.emptyChat = false
            if(!_.isEmpty(this.chats)) {
                this.$nextTick(() => {
                    VueScrollTo.scrollTo("div.messages ul li:last-child", 0, {
                        container: '.messages'
                    })
                })
            }
            this.saveChatToDB()
        },
        getChatList(receiverID) {
            this.loadStatus = true
            this.emptyChat = false
            this.showChatText = false

            const userID = $("meta[name=user-id]").attr("content")
            
            this.chats = []
            axios.get('/api/chat/list/'+userID+'/'+receiverID)
            .then((response) => {
                this.loadStatus = false
                let chatDB = response.data
                this.chats = chatDB
                this.showChatText = true
                if(chatDB.length == 0 || chatDB === undefined) {
                    this.emptyChat = true
                }
                if(!_.isEmpty(this.chats)) {
                    this.$nextTick(() => {
                        VueScrollTo.scrollTo("div.messages ul li:last-child", 0, {
                            container: '.messages'
                        })
                    })
                }
            })
            .catch((error) => {
                this.loadStatus = false
                this.emptyChat = false
                console.log(error);
            })
            .then(function() {
                // always executed
            });
        },
        saveChatToDB() {
            const userID = $("meta[name=user-id]").attr("content")

            axios.post('/api/chat/insert', {
                message: this.messagetext,
                sender_id: userID,
                receive_id: this.id
            })
            .then((response) => {
                this.messagetext = ''
            })
            .catch((error) => {
                this.messagetext = ''
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
</style>
