<template>
    <div>
        <h2>SHOP</h2>
        <div class="shop-container">
            <div class="products-container">
                <div 
                    class="product"
                    v-for="(product) in shoppingcart"
                    :key='product._id'  
                >
                    <h4>{{product.title}}</h4>
                    <img class="product-img" :src="product.design_url">
                    <p class="size">{{product.size}}</p>
                    <p class="price">
                        ${{ product.price }}

                    </p>
                    <div class="shop-actions">
                        <button @click="remove(product)"> - </button>
                        <span class="quantity">{{product.quantity}}</span>
                        <button @click="add(product)"> + </button>
                    </div>
                </div>
            </div>

            <div class="cart-container">
                <label>Items in cart: </label>
                <div class="cart-items">
                    <div
                        v-for="product in shoppingcart"
                        :key="product._id"
                    >
                    <p v-if="product.quantity > 0">
                        <label>{{product.title}}</label>
                        <img :src="product.design_url">
                        <span>| x {{product.quantity}}</span>
                    </p>
                    </div>
                </div>

                <div v-if="totalItems > 0">
                    <button @click="placeOrder()"> Place Order</button>
                </div>
            </div>
        </div>       
    </div>
</template>

<script>
    export default {
        data () {
            return {
                products: [],
                shoppingcart: [],
                showCart: false,
            }
        },
        mounted(){
            this.fetchProducts();
        },
        computed: {
            cart(){
                return this.shoppingcart.filter(product => product.quantity > 0);
            },
            totalItems(){   
                return this.shoppingcart.reduce(
                    (total, product) => total + product.quantity, 0
                );
            },

        },
        methods: {
            remove(product){
                for(let i = 0; i < this.shoppingcart.length; i++){
                    if(this.shoppingcart[i].id === product.id){
                        if(this.shoppingcart[i].quantity !== 0){
                            this.shoppingcart[i].quantity--;
                            return;
                        }                        
                    }
                }
            },
            add(product){
                for(let i = 0; i < this.shoppingcart.length; i++){
                    if(this.shoppingcart[i].id === product.id){
                        this.shoppingcart[i].quantity++;
                        return;
                    }
                }
            },
            placeOrder(){
                // console.log(this.shoppingcart);
                var payload = {
                    customerId: 1,
                    cart:[]
                };

                for(let i = 0; i < this.shoppingcart.length; i++){
                    if(this.shoppingcart[i].quantity > 0){
                        payload.cart.push({
                            productId: this.shoppingcart[i].id,
                            quantity: this.shoppingcart[i].quantity
                        })
                    }
                }

                if(payload.cart.length === 0){
                    alert('shopping cart items not added');
                    return;
                }

                axios.post('/api/orders', payload)
                    .then( (response) => {
                        console.log(response, 'success')

                        if(response.status === 200){
                            this.$router.push('orders')
                        }
                    })
                    .catch((error) => {
                        alert(error.response.data.error);
                        console.log(error, 'error');
                    });
                
            },
            fetchProducts(){
                axios.get('/api/products')
                .then((response) => {
                    this.products = response.data;

                    this.products.forEach( product => {
                        this.shoppingcart.push({
                            id          : product.product_id,
                            title       : product.title,
                            design_url  : product.design_url,
                            size        : product.size,
                            price       : product.price,
                            quantity    : 0
                        })
                    });
                    console.log(response.data);
                })
                .catch((error) => {
                    alert(error.response.data.error);
                    console.log(error.response, 'error');
                });
            }
        }
    }
</script>