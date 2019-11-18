import Vue from 'vue'
import CreatePost from './pages/CreatePost'

export default function Blog () {
    const app = new Vue({
        el: 'main.blog',
        components: {
            CreatePost
        }
    })
}