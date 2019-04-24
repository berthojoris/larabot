<template>
<div @click="openChat(user.id, user.image, user.name)">
    <li @click="activate(user.id)" class="contact">
        <div class="wrap">
            <span :id="user.id" class="contact-status online"></span>
            <img :src="user.image">
            <div class="meta">
                <div :id="user.id" class="mtop">
                    <p class="name" v-text="user.name" style="display: inline-block;"></p>
                    <p class="typingNotif showhide"> is typing...</p>
                    <p class="preview" :id="user.id" v-text="this.lastChat"></p>
                </div>
               
            </div>
        </div>
    </li>
</div>
</template>

<script>
export default {
    props: ['user', 'senderID', 'receiveID', 'message', 'pushdata', 'idToSend', 'typeIndi'],
    data() {
        return {
            online: true,
            lastChat: 'Click to start chat',
            activePeer: false,
            chatStatus: false
        }
    },
    mounted() {
        
    },
    watch: {
        typeIndi: function() {
            if(this.typeIndi[3] == 'hide') {
                $("ul#listUser").find("div#"+this.typeIndi[0]).find(".typingNotif").removeClass().addClass("typingNotif showhide")
            } else {
                if(this.typeIndi[2] == window.App.user.id) {
                    $("ul#listUser").find("div#"+this.typeIndi[0]).find(".typingNotif").removeClass().addClass("typingNotif")
                }
            }
        },
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
                        if(!this.chatStatus) {
                            $("span#"+val.sender_id).removeClass().addClass('contact-status busy')
                        }
                    }
                })
            }
        }
    },
    methods: {
        openChat: function(id, image, name) {
            this.$emit('openChatNow', id, image, name)
            this.chatStatus = true
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
