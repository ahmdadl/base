import Vue from 'vue'
import Component from 'vue-class-component'

@Component({
    props: {
        type: {
            type: String,
            required: false,
            default: 'info'
        },
        for: {
            type: Number,
            default: 5
        }
    },
    template: `<div ref='parent' class="alert alert-dismissible fade show transition" :class="'alert-' + type" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="closeMe"><span aria-hidden="true">&times;</span>
    </button>
    <slot></slot>
    </div>`
})
export default class Alert extends Vue
{
    public closeMe() {
        let el = this.$refs.parent as HTMLElement
        if (el) el.style.opacity = '0';
    }

    mounted () {
        setTimeout(this.closeMe, this.$props.for * 1000)
    }
}