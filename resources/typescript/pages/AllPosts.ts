import Vue from "vue";
import Component from "vue-class-component";
import setSlotData from "../partials/setSlotData";

@Component({
    template: require("./template.html")
})
export default class AllPosts extends Vue
{
    public d: this = this;
    public cardClass = 'col-md-6'
    public rowClass = 'col-12'
    public cardLayout = 'grid'

    public layoutChanger (type: string) : void
    {
        if (type === 'classic') {
            this.d.cardClass = 'col-md-12'
            this.d.rowClass = 'col-12'
            this.d.cardLayout = type
        } else if (type === 'list') {
            this.d.cardClass = 'col-md-12'
            this.d.rowClass = 'col-lg-6'
            this.d.cardLayout = type
        } else {
            this.d.cardClass = 'col-md-6'
            this.d.rowClass = 'col-12'
            this.d.cardLayout = type
        }
    }

    mounted() {
        // set all to allow parent to use it
        this.d = setSlotData(this, 'layoutChanger') as this;
    }
}