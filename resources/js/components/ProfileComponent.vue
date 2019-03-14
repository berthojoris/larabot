<template>
<div id="profile">
    <div class="wrap">
        <img :src="picture" id="profile-img" class="online" @click="truncate">
        <p>{{ name }}</p>
        <i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>
        <div id="status-options">
            <ul>
                <li id="status-online" class="active">
                    <span class="status-circle"></span>
                    <p>Online</p>
                </li>
                <li id="status-away">
                    <span class="status-circle"></span>
                    <p>Away</p>
                </li>
                <li id="status-busy">
                    <span class="status-circle"></span>
                    <p>Busy</p>
                </li>
                <li id="status-offline">
                    <span class="status-circle"></span>
                    <p>Offline</p>
                </li>
            </ul>
        </div>
        <div id="expanded">
            <label for="twitter"><i class="fa fa-facebook fa-fw" aria-hidden="true"></i></label>
            <input name="twitter" type="text" value="mikeross" />
            <label for="twitter"><i class="fa fa-twitter fa-fw" aria-hidden="true"></i></label>
            <input name="twitter" type="text" value="ross81" />
            <label for="twitter"><i class="fa fa-instagram fa-fw" aria-hidden="true"></i></label>
            <input name="twitter" type="text" value="mike.ross" />
        </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            picture: null,
            userid: null,
            name: null
        }
    },
    mounted() {
        this.userid = window.App.user.id
        this.picture = window.App.user.image
        this.name = window.App.user.name
    },
    methods: {
        truncate: function() {
            this.$emit('del')
        }
    }
}
</script>

<style scoped>

</style>

