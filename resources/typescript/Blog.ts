import Vue from 'vue'
import CreatePost from './pages/CreatePost'
import AllPosts from './pages/AllPosts';
import ShowPost from './pages/ShowPost'

export default function Blog () {
    const app = new Vue({
        el: 'main.blog',
        components: {
            CreatePost,
            AllPosts,
            ShowPost
        },
        mounted () {
            // hide splash screen
            this.$refs.splashScreen.style.display = 'none'
        }
    })
}