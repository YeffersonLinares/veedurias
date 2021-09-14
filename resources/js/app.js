import $ from 'jquery';
require('./bootstrap');
import router from './routes'
import { useRoute } from 'vue-router';

window.Vue = require('vue');

//

Vue.component('edit-veeduria', require('./components/editar_veeduria.vue').default);
Vue.component('list-veeduria', require('./components/lista_veeduria.vue').default);
Vue.component('informe-veeduria', require('./components/informe_veeduria.vue').default);
Vue.component('nueva-veeduria', require('./components/NuevaVeeduria.vue').default);
Vue.component('detalles-veeduria', require('./components/VisualizacionVeeduria.vue').default);
Vue.component('editar-veeduria', require('./components/EditarVeeduria.vue').default);


Vue.directive('permiso', function (el, binding,vnode) {
  if(superAdmin == '1'){
    return vnode.elm.hidden = false;
  }else{
    if(Permissions.indexOf(binding.value) !== -1){
        return vnode.elm.hidden = false;
    }else{
        return vnode.elm.hidden = true;
    }
  }
})

const app = new Vue({
    router,
    el: '#app',
    props: {},
    components:{
    },
    data :{
      menu : 0,
    },
    methods: {
    },
});
