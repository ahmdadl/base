import Vue from "vue";
import Component from "vue-class-component";
import setSlotData from "../partials/setSlotData";
import Axios from 'axios';
import removePost from '../partials/removePost';

@Component({
    template: require("./template.html")
})
export default class AllPosts extends Vue
{
    public d: this = this;
    public cardClass = 'col-md-6'
    public rowClass = 'col-12'
    public cardLayout = 'grid'
    public delLoad = false

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

    public deletePost (pid, redirect = false)
    {
        removePost(this, pid, redirect)
    }

    mounted() {
        // set all to allow parent to use it
        this.d = setSlotData(this, 'layoutChanger', 'deletePost') as this;
    }
}