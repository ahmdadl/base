import Vue from "vue";
import Component from "vue-class-component";
import setSlotData from "../partials/setSlotData";

@Component({
    template: require("./template.html")
})
export default class CreatePost extends Vue {
    public d = this;
    public file: File
    public title = "";
    public imagePrev: string = ''
    public showPrev: boolean = false
    public body = "";
    public titleErr: null | boolean = null;
    public imgErr: null | boolean = null;
    public bodyErr: null | boolean = null;

    public beforeSubmit() {
        this.d.titleErr = this.d.imgErr = this.d.bodyErr = null;

        if (this.d.title.length < 5) {
            this.d.titleErr = true;
        }

        if (this.d.body.length < 25) {
            this.d.bodyErr = true;
        }

        if (null === this.d.titleErr && null === this.d.bodyErr) {
            let x = this.$refs.createPostForm as HTMLFormElement;
            x.submit();
        }
    }

    public handleFile (ev) {
       this.d.imagePrev = ''
       this.d.showPrev = false

       let file = ev.target.files[0]
       let reader = new FileReader()

       reader.addEventListener("load", function () {
        this.d.imagePrev = reader.result;
        this.d.showPrev = true
      }.bind(this), false);

      if (file) {
        if ( /\.(jpe?g|png|gif)$/i.test( file.name ) ) {
            reader.readAsDataURL( file );
          }
      }
    }

    mounted() {
        // set all to allow parent to use it
        this.d = setSlotData(this, "beforeSubmit", 'handleFile') as this;
    }
}
