<template>
<div class="content">
    <div v-show="!chats.length" class="center">
        No chat available at this moment
    </div>

    <div v-if="chats.length" class="contact-profile">
        <img src="images/man2.png" alt="" />
        <p>Brian</p>
        <div class="social-media">
            <i class="fa fa-facebook" aria-hidden="true"></i>
            <i class="fa fa-twitter" aria-hidden="true"></i>
            <i class="fa fa-instagram" aria-hidden="true"></i>
        </div>
    </div>
    <div class="messages">
        <ul>
            <li v-for="(chat, index) in chats" :key="index" v-bind:class="{'sent': chat.type == 'sent',  'replies': chat.type == 'replies'}">
                <img :src="chat.image">
                <p>{{ chat.message }}</p>
            </li>
        </ul>
    </div>
    <div class="message-input">
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
    data() {
        return {
            messagetext: '',
            profile: 'images/man1.png',
            chats: []
        }
    },
    mounted() {
        // this.getChatList()
    },
    methods: {
        sendMessage() {
            if (this.messagetext.trim().length < 1) return;
            this.chats.push({
                image: this.profile,
                type: 'sent',
                message: this.messagetext
            })
            VueScrollTo.scrollTo("ul li:last-child", 0, {
                container: '.messages'
            })
            this.saveChatToDB()
        },
        getChatList() {
            axios.get('/api/chat/list/1/2')
            .then((response) => {
                let chatDB = response.data
                this.chats = chatDB
            })
            .catch((error) => {
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
                sender_id: userID
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
