<template>
    <div id="app">
        <div class="container">
            <nav>
                <router-link to="/shop">Shop</router-link>
                <router-link to="/orders">Orders</router-link>
                <router-link to="/sheets"> Sheets</router-link>
            </nav>
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
export default {
    mounted(){
        this.$router.push('shop')
    }
}
</script>