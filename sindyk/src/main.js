import Vue from 'vue'
import App from './App.vue'
import store from './store'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueEvents from 'vue-events'

import 'bulma'

Vue.use(VueAxios, axios)
Vue.use(VueEvents)

Vue.config.productionTip = false

new Vue({
  store,
  render: h => h(App)
}).$mount('#app')
