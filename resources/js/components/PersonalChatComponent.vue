<template>
<div class="content">

    <div v-if="!getOpenChatStatus" class="centerText">
        <p>"Stay connected with people around you"</p>
    </div>

    <div v-if="getEmptyMessage" class="circonf-wrapper centerText">
        <p>Sorry there is no chat history with this user</p>
    </div>

    <div class="item loading-5" v-if="getLoadingMessage">
        <div class="svg-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em">
                <circle cx="0.6em" cy="0.6em" r="0.5em" class="circle"/>
            </svg>
        </div>
    </div>

    <div v-if="chats.length" class="contact-profile">
        <div>
            <img :src="getReceiver.image">
            <p class="normal">{{ getReceiver.name }}</p>
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
            <li v-for="(chat, index) in chats" :key="index" :class="{'sent': chat.sender_id == getPersonalData.id,  'replies': chat.sender_id != getPersonalData.id}">
                <img :src="chat.sender_image" v-if="chat.sender_id == getPersonalData.id">
                <img :src="chat.sender_image" v-if="chat.sender_id != getPersonalData.id">
                <p>{{ chat.message }}</p>
            </li>
        </ul>
    </div>
    <div v-if="getTypingMessage" class="message-input">
        <div class="wrap">
            <input ref="writemsg" type="text" @keyup.enter="send" v-model="message" placeholder="Write your message..." />
            <i class="fa fa-paperclip attachment" aria-hidden="true"></i>
            <button @click="send" class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
        </div>
    </div>
</div>
</template>

<script>
import {mapGetters, mapActions} from "vuex"

export default {
    data() {
        return {
            messagetext: '',
            chats: [],
        }
    },
    computed: {
        ...mapGetters([
            "getReceiver",
            "getPersonalData",
            "getChatHistory",
            "getLoadingMessage",
            "getEmptyMessage",
            "getOpenChatStatus",
            "getTypingMessage",
            "getRandomString",
        ]),
        message: {
            get() {
                return this.$store.state.message
            },
            set(value) {
                return this.$store.commit('message', value)
            },
        },
    },
    mounted() {
        // this.messagetext = this.getRandomString
    },
    watch: {
        getChatHistory: function() {
            this.chats = this.getChatHistory
            this.$nextTick(() => {
                VueScrollTo.scrollTo("div.messages ul li:last-child", 0, {
                    container: '.messages'
                })
            })
            // this.messagetext = this.getRandomString
        }
    },
    methods: {
        ...mapActions([
            'send'
        ]),
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
