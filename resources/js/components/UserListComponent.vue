<template>
<div>
    <li class="contact">
        <div class="wrap">
            <span class="contact-status online"></span>
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
    props: ['user']
}
</script>

<style scoped>

</style>
