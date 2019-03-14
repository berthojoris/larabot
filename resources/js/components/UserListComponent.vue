<template>
<div @click="openChat(user.id, user.image, user.name)">
    <li @click="activate(user.id)" class="contact">
        <div class="wrap">
            <span at :id="user.id" class="contact-status online"></span>
            <img :src="user.image">
            <div class="meta">
                <p class="name" v-text="user.name"></p>
                <p class="preview" :id="user.id" v-text="this.lastChat"></p>
            </div>
        </div>
    </li>
</div>
</template>

<script>
export default {
    props: ['user', 'senderID', 'receiveID', 'message', 'pushdata', 'idToSend'],
    data() {
        return {
            online: true,
            lastChat: 'Click to start chat'
        }
    },
    watch: {
        idToSend: function() {
            this.$nextTick(() => {
                $("span#"+this.idToSend).removeClass().addClass('contact-status online')
            })
        },
        message: function() {
            this.lastChat = this.message
        },
        pushdata: function(val) {
            if(!_.isEmpty(val)) {
                this.$nextTick(() => {
                    if(val.receive_id == window.App.user.id) {
                        $("span#"+val.sender_id).removeClass().addClass('contact-status busy')
                    }
                })
            }
        }
    },
    methods: {
        openChat: function(id, image, name) {
            this.$emit('openChatNow', id, image, name)
        },
        activate: function(id) {
            $('body').on('click', 'li', function() {
                $('li.active').removeClass('active');
                $(this).addClass('active');
            });
        }
    }
}
</script>

<style scoped>

</style>
