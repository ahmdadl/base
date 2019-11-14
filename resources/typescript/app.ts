import Vue, { VNode } from "vue";
import Component from "vue-class-component";
import Axios from "axios";
import textWriter from './components/textWriter'
import animatedDots from './components/animatedDots'
import Progress from './components/Progress'
import { al } from "./partials/help";

Vue.config.productionTip = false;

Vue.component('animated-job-title', textWriter)
Vue.component('animated-dots', animatedDots)
Vue.component('dync-progress', Progress)

let app = new Vue({
    el: ".landing-page",
    data: {
        
    },
    mounted () {
        
    }
})
