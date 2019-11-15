import Vue from 'vue'
import Component from 'vue-class-component'

@Component({
    props: {
        links: {
            type: String,
            required: true
        }
    },
    template: require('./SideNav.html')
})
export default class SideNav extends Vue
{
    public data = []
    public active = ''

    public setActive (el: HTMLElement) {
        this.active = el.id
    }

    mounted () {
        this.data = this.$props.links.split(' ')
    }
}