<template>
    <div>
        <h2> PRODUCTS IN SHOP</h2>
        <ul>
            <li 
                v-for='product in products'
                :key='product._id'  
            >
                {{product.title}}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data () {
        return {
            products: []
        }
    },
    mounted(){
       this.fetch();
    },
    methods: {
        fetch(){
             axios.get('/api/products')
            .then((response) => {
                this.products = response.data;
                console.log(response.data);
            });
        }
    }
}
</script>