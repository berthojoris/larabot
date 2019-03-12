<template>
<div id="frame">
    <div id="sidepanel">
        <comp-profile></comp-profile>
        
        <comp-search></comp-search>
        
        <div id="contacts">
            <ul>
                <comp-user-list 
                    v-for="(user, index) in userlist" 
                    :key="index" 
                    :user="user" @openChatNow="openChatViaID">
                </comp-user-list>
            </ul>
        </div>
        
        <comp-menu></comp-menu>
    </div>

    <comp-personal-chat></comp-personal-chat>
</div>
</template>

<script>
export default {
    data() {
        return {
            userlist : []
        }
    },
    mounted() {
        this.getUserList()
    },
    methods: {
        openChatViaID(id) {
            alert(id)
        },
        getUserList() {
            const userID = $("meta[name=user-id]").attr("content")

            axios.get('/api/user/online/'+userID)
            .then((response) => {
                let listUserDB = response.data
                this.userlist = listUserDB
            })
            .catch((error) => {
                console.log(error);
            });
        }
    }
}
</script>

<style scoped>

</style>
