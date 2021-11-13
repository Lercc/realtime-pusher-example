<template>
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-bell"></i>
            <span class="badge badge-danger">{{ notifications.length > 0 ? notifications.length : '' }}</span>
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

            <li v-for="(notification, i) in notifications" :key="`${i}-not`">
                <div class="dropdown-divider" v-show="i == 0 ? false : true"></div>

                <a :href="notification.url" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> {{ notification.description }}
                    <span class="ml-3 pull-right text-muted text-sm">
                        <timeago :datetime="notification.time" :auto-update="60"></timeago>
                    </span>
                </a>
            </li>
        </ul>
    </li>
</template>

<script>
import VueTimeago from 'vue-timeago'

Vue.use(VueTimeago, {
  name: 'Timeago',
  locale: 'en',
  locales: {
    'zh-CN': require('date-fns/locale/zh_cn'),
    ja: require('date-fns/locale/ja')
  }
})

export default {
    name: 'OrderNotification',
    props: [ 'user_id' ],
    data: () => ({
        notifications:[],
    }),
    mounted () {
        window.Echo.channel('pizza-tracker')
        .listen('OrderStatusChangedEvent', e => {
            if (this.user_id == e.user_id) {
                this.notifications.unshift({
                    description: `Order ID:  + ${e.id} updated `,
                    url : `/order/${e.id}`,
                    time: new Date()
                })
            }
        })
    }
}
</script>