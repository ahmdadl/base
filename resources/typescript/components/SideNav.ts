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
        let sections = document.querySelectorAll('#top, section') as NodeListOf<HTMLElement>,
            doc = document.documentElement as HTMLElement

        // initalize of first load
        sections.forEach(sec => {
            if (sec.offsetTop - doc.scrollTop < 75) {
                this.active = sec.id
            }
        })

        document.addEventListener('scroll', ev => {
            sections.forEach(sec => {
                if (sec.offsetTop - doc.scrollTop < 75) {
                    this.active = sec.id
                }
            })
        })
    }
}