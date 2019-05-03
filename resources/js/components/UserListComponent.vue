<template>
<div @click="openChat(user.id, user.image, user.name)">
    <li @click="setActiveClass" class="contact">
        <div class="wrap">
            <span v-if="user.online_status === 'ONLINE'" :id="user.id" class="contact-status online"></span>
            <span v-else :id="user.id" class="contact-status busy"></span>
            <img :src="user.image">
            <div class="meta">
                <div :id="user.id" class="mtop">
                    <p class="name" v-text="user.name" style="display: inline-block;"></p>
                    <p class="typingNotif showhide"> is typing...</p>
                    <p class="preview" :id="user.id" v-text="user.last_message"></p>
                </div>
            </div>
        </div>
    </li>
</div>
</template>

<script>
import {mapGetters, mapActions} from "vuex"
export default {
    props: ['user'],
    data() {
        return {
            lastChat: 'Click to start chat',
        }
    },
    computed: {
        ...mapGetters([
            "getReceiver",
            "getOpenChatStatus",
            "getChatHistory"
        ]),
    },
    methods: {
        ...mapActions([
            "openChatWith",
            "setOpenChatStatus",
            "openChatHistory"
        ]),
        openChat: function(id, image, name) {
            this.openChatWith(id)
            this.setOpenChatStatus()
            this.openChatHistory(id)
        },
        setActiveClass: function() {
            $('body').on('click', 'li', function() {
                $('li.active').removeClass('active');
                $(this).addClass('active');
            });
        }
    }
}
</script>

<style scoped>
.typingNotif {
    display: inline-block;
    font-style: italic;
    color: greenyellow;
    margin-bottom: 0px;
}
.showhide {
    display: none;
}
.mtop {
    margin-top: -8px;
}
</style>
