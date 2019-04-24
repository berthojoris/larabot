<template>
<div id="bottom-bar">
    <button id="createGroupChat"
        class="btn green"
        @click="$modal.show('demo-login')">
        <i class="fa fa-user-plus fa-fw" aria-hidden="true"></i>
        Group Invite
    </button>
    <button id="accountSetting">
        <i class="fa fa-cog fa-fw" aria-hidden="true"></i> 
        <span>Settings</span>
    </button>
</div>
</template>

<script>
export default {
    mounted() {
        
    },
}
</script>

<style scoped>

</style>

