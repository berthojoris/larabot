<template>
<div @click="openChat(user.id, user.image, user.name)">
    <li @click="activate(user.id)" class="contact">
        <div class="wrap">
            <span class="contact-status offline"></span>
            <img :src="user.image">
            <div class="meta">
                <p class="name">{{ user.name }}</p>
                <p class="preview">{{ user.message }}</p>
            </div>
        </div>
    </li>
</div>
</template>

<script>
export default {
    props: ['user'],
    data() {
        return {
            
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
