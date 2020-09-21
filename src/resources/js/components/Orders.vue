<template>
    <div class="orders-container">
        <h2> Orders</h2>
        <!-- <ul class="orders">
            <li 
                v-for='order in orders'
                :key='order._id'  
            >
               <label>Order Number: </label> {{order.order_number}} <br/>
               <label>Items Purchased: </label> {{order.order_items.length}} <br/>
               <label>Status: </label> {{order.order_status}} <br/>
            </li>
        </ul> -->
        <button @click="process()"> Process Pending Orders </button>

        <div class="orders-table">
                <div class="col header">Order Number</div>
                <div class="col header">Items Purchased</div>
                <div class="col header">Status</div>
                <div class="col header">Last Updated </div>

            <template  
                v-for='order in orders'  
                class="row"
            >
                <div :key='order._id'  class="col">{{order.order_number}}</div>
                <div :key='order._id'  class="col">{{order.order_items.length}}</div>
                <div :key='order._id'  class="col">{{order.order_status}}</div>
                <div :key='order._id'  class="col">{{order.updated_at}}</div>
            </template>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            orders: []
        }
    },
    mounted(){
       this.fetch();
    },
    methods: {
        process(){
            console.log('dispatch process');

            axios.get('/api/process')
            .then((response) => {
                console.log(response);

                this.fetch();
            });
            

            // this.$router.push('orders');
            this.fetch();
        },
        fetch(){
            axios.get('/api/orders')
            .then((response) => {
                this.orders = response.data;
                console.log(response.data);
            });
        }
    }
}
</script>