import Vue, { VNode } from "vue";
import VueScrollTo from 'vue-scrollto'
import Axios from "axios";

// controllers
import LandingPage from './Landing'
import Blog from './Blog'

import textWriter from "./components/textWriter";
import animatedDots from "./components/animatedDots";
import Progress from "./components/Progress";
import Card from "./components/Card";
import Alert from "./components/Alert";
import SideNav from './components/SideNav'

Vue.config.productionTip = false;

Vue.use(VueScrollTo, {
    duration: 1000,
    offset: -70
})

Vue.component("alert", Alert);
Vue.component("animated-job-title", textWriter);
Vue.component("animated-dots", animatedDots);
Vue.component("dync-progress", Progress);
Vue.component("card", Card);
Vue.component('side-nav', SideNav)

/**
 * create directive to init model value
 */
Vue.directive('init', {
    bind: function (el, binding, vnode) {
        vnode.context.$children[0][binding.arg] = binding.value
    }
})

let currentPage = '',
    path = location.pathname

if (path === '/') {
    LandingPage()
} else {
    Blog()
}
