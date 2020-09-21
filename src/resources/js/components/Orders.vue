<template>
    <div>
        <h2> Orders</h2>
        <ul>
            <li 
                v-for='order in orders'
                :key='order._id'  
            >
               <label>Order Number: </label> {{order.order_number}} <br/>
               <label>Items Purchased: </label> {{order.order_items.length}} <br/>
               <label>Status: </label> {{order.order_status}} <br/>
            </li>
        </ul>
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
        fetch(){
            axios.get('http://localhost:8080/api/orders')
            .then((response) => {
                this.orders = response.data;
                console.log(response.data);
            });
        }
    }
}
</script>