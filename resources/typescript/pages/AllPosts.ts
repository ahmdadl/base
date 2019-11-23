import Vue from "vue";
import Component from "vue-class-component";
import setSlotData from "../partials/setSlotData";

@Component({
    template: require("./template.html")
})
export default class AllPosts extends Vue
{
    public d: this = this;

    mounted() {
        // set all to allow parent to use it
        this.d = setSlotData(this) as this;
    }
}