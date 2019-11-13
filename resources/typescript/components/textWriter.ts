import Vue, { VNode } from "vue";
import Component from "vue-class-component";

@Component({
    template: '<span>{{str}}</span>'
})
export default class textWriter extends Vue
{
    public arr = [
        'A will not rendered',
        'A Back End Web Developer',
        'A Laravel Developer',
        'A Full Stack Web Developer'
    ]
    public i = 0
    public j = 0
    public str = 'A Full Stack Web Developer'
    public speed = 90

    public typeWriter() {
        if (this.arr[this.i] && this.j >= this.arr[this.i].length) return;
        this.str += this.arr[this.i].charAt(this.j)
        this.j++;
        setTimeout(this.typeWriter, this.speed);
    }

    mounted () {
        setInterval(_ => {
            if (this.i > 2) this.i = 0;
            let speed = 90;
            if (this.j >= this.arr[this.i].length) this.j = 0;
            this.str = ''
            
            this.typeWriter();
            this.i++;
        }, 4000)
    }
}