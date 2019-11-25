import Vue from "vue";
import Component from "vue-class-component";

@Component({
    props: {
        hasOverlay: {
            type: Boolean,
            required: false,
            default: false
        },
        cls: {
            type: String,
            required: true
        },
        img: {
            type: String,
            required: true
        },
        title: {
            type: String,
            required: true
        },
        href: {
            type: String,
            required: false
        },
        rowClass: {
            type: String,
            required: false,
            default: 'col-12'
        }
    },
    template: require("./card.html")
})
export default class Card extends Vue {}
