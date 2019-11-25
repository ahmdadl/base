import Vue from 'vue'
import CreatePost from './pages/CreatePost'
import AllPosts from './pages/AllPosts';

export default function Blog () {
    const app = new Vue({
        el: 'main.blog',
        components: {
            CreatePost,
            AllPosts
        }
    })
}