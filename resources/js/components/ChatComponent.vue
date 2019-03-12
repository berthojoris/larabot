<template>
<div id="frame">
    <div id="sidepanel">
        <comp-profile></comp-profile>
        
        <comp-search></comp-search>
        
        <div id="contacts">
            <ul>
                <comp-user-list v-for="(user, index) in userlist" :key="index" :user="user"></comp-user-list>
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
            userlist : [
                {
                    id: 2,
                    image: 'images/man2.png',
                    name: 'Brian',
                    message: 'Woi brian, pa kbr bro? Lama gak liat...Gmna kbr skrng? Kerja dmna skrng?'
                },
                {
                    id: 3,
                    image: 'images/man3.png',
                    name: 'Ronald',
                    message: 'Dimana lau? Gw di P5 ni'
                }
            ]
        }
    },
    methods: {
        openChat(user) {
            alert("Chat personal opened")
        }
    }
}
</script>

<style scoped>

</style>
