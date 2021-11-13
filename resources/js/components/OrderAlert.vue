<template>
    <alert v-model="showAlert" placement="top-right" duration="3000" type="success" width="400px" dismissable>
        <span class="icon-ok-circled alert-icon-float-left"></span>
        <strong>Order status updated!</strong>
        <p>
            Order ID {{ order_id }} has been updated.
            <br>
            Status: {{ status }}
        </p>
    </alert>
</template>

<script>
import { alert } from 'vue-strap'

export default {
    name: 'OrderAlert',
    components: { alert },
    props: [ 'user_id' ],
    data: () => ({
        status: '',
        showAlert: false,
        order_id: ''
    }),
    mounted () {
        window.Echo.channel('pizza-tracker')
        .listen('OrderStatusChangedEvent', e => {
            if ( this.user_id == e.user_id ) {
                this.order_id = e.id
                this.status = e.status_name
                this.showAlert = true
            }
        })
    }
}
</script>