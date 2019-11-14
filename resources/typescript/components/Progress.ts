import Vue from 'vue'
import Component from 'vue-class-component'

@Component({
    props: {
        txt: {
            type: String,
            required: true
        },
        val: {
            type: Number,
            required: true
        }
    },
    template: `<div class="progress mt-3 mx-2 font-weight-bolder" style="height: 25px;">
    <span class="px-3 pt-1 align-middle text-light bg-dark text-uppercase" v-text="txt"></span>
    <div class="progress-bar bg-success text-right" role="progressbar" :style="'width: ' + width + '%'" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">{{val}}%</div>
    </div>
    `
})
export default class Progress extends Vue
{
    public width = 0

    public isScrolled(ev: Event) {
        let s = document.querySelector('#skills') as HTMLElement
        const DOC = document.documentElement as HTMLElement
        
        if ((s.offsetTop - DOC.scrollTop) < 60) {
            setTimeout(_ => {this.width = this.$props.val}, 150)
        }
    }

    mounted () {
        document.addEventListener('scroll', this.isScrolled)
    }
}