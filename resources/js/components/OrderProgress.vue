<template>
    <div>
        <div class="progress">
            <progressbar :now="progress" type="primary" striped></progressbar>
        </div>

        <div class="order-status">
            <strong>Order Status:</strong> {{ statusNew }}
        </div>
    </div>
</template>

<script>
import { progressbar } from 'vue-strap'

export default {
    name: 'OrderProgress',
    components: { progressbar },
    props: ['status', 'initial', 'order_id'],
    data: () => ({
        statusNew: '',
        progress: ''
    }),
    created () {
        this.statusNew = this.status
        this.progress = this.initial
    },
    mounted () {
        // window.Echo.channel('pizza-tracker')
        window.Echo.channel('pizza-tracker.'+ this.order_id)
        .listen('OrderStatusChangedEvent', e => {
            console.log('pizza-updated : ', e.id);
            this.statusNew = e.status_name
            this.progress = e.status_percent
        })
    }
}
</script>Q