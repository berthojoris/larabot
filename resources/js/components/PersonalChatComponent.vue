<template>
<div class="content">
    <div class="contact-profile">
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
            chats: [],
            dummychats: [
                {
                    image: 'images/man1.png',
                    type: 'sent',
                    message: 'Woi brian, pa kbr bro? Lama gak liat...Gmna kbr skrng? Kerja dmna skrng?'
                },
                {
                    image: 'images/man2.png',
                    type: 'replies',
                    message: "Kabar baik bro...Gimna u? Makin sukses aja ne gw liat. Kapan ne meet up lagi broh?"
                },
                {
                    image: 'images/man1.png',
                    type: 'sent',
                    message: 'Minggu depan gimana? Gw ada acara d rumah juga ne. Skalian mau ajak anak2 pada ngumpul'
                },
                {
                    image: 'images/man2.png',
                    type: 'replies',
                    message: "Ah...boleh juga :D btw skalian gw mau kasi undangan ya"
                },
                {
                    image: 'images/man1.png',
                    type: 'sent',
                    message: 'Siap 86 gan.....Meluncur ke KTP'
                },
            ]
        }
    },
    mounted() {
        this.getChatList()
    },
    methods: {
        sendMessage() {
            if (this.messagetext.trim().length < 1) return;
            this.chats.push({
                image: this.profile,
                type: 'sent',
                message: this.messagetext
            })
            this.saveChatToDB()
            VueScrollTo.scrollTo("ul li:last-child", 0, {
                container: '.messages'
            })
            this.messagetext = ''
        },
        getChatList() {
            var self = this;
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
            axios.post('/api/chat/insert', {
                message: this.messagetext
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

</style>
