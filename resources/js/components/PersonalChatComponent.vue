<template>
<div class="content">

    <div v-if="nochat" class="circonf-wrapper center">
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
            <li v-for="(chat, index) in chats" :key="index" v-bind:class="{'sent': chat.type == 'sent',  'replies': chat.type == 'replies'}">
                <img :src="chat.image">
                <p>{{ chat.message }}</p>
            </li>
        </ul>
    </div>
    <div v-if="chats.length" class="message-input">
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
            nochat: false
        }
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
                image: picture,
                type: 'sent',
                message: this.messagetext
            })
            VueScrollTo.scrollTo("ul li:last-child", 0, {
                container: '.messages'
            })
            this.saveChatToDB()
        },
        getChatList(receiverID) {
            this.loadStatus = true
            this.nochat = false
            const userID = $("meta[name=user-id]").attr("content")
            
            this.chats = []
            axios.get('/api/chat/list/'+userID+'/'+receiverID)
            .then((response) => {
                this.loadStatus = false
                let chatDB = response.data
                this.chats = chatDB
                if(chatDB.length == 0 || chatDB === undefined) {
                    this.nochat = true
                }
            })
            .catch((error) => {
                this.loadStatus = false
                this.nochat = false
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
