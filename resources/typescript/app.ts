import Vue, { VNode } from "vue";
import Component from "vue-class-component";
import Axios from "axios";
import textWriter from './components/textWriter'
import animatedDots from './components/animatedDots'
import Progress from './components/Progress'
import Card from './components/Card'
import { al } from "./partials/help";

Vue.config.productionTip = false;

Vue.component('animated-job-title', textWriter)
Vue.component('animated-dots', animatedDots)
Vue.component('dync-progress', Progress)
Vue.component('card', Card)

let app = new Vue({
    el: ".landing-page",
    data: {
        
    },
    mounted () {
        document.addEventListener('scroll', ev => {
            let doc = document.documentElement as HTMLElement,
                navbar = document.querySelector('.navbar') as HTMLElement

            if (doc.scrollTop > 300) {
                navbar.classList.remove('bg-transparent')
            } else {
                navbar.classList.add('bg-transparent')
            }
        })
    }
})
