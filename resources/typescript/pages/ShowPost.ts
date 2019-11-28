import Vue from "vue";
import Component from "vue-class-component";
import setSlotData from "../partials/setSlotData";
import Axios from "axios";

@Component({
    template: require("./template.html")
})
export default class ShowPost extends Vue {
    public d: this = this;
    public postID: null | number = null
    public name = "";
    public email = "";
    public message = "";
    public nameErr: null | boolean = null;
    public emailErr: null | boolean = null;
    public messErr: null | boolean = null;
    public commErr: null | boolean = null;
    public commenting: null | boolean = null;
    public csrfToken = ''

    public validateEmail(email: string): boolean {
        let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{1,}))$/;
        return re.test(String(email).toLowerCase());
    }

    public validateName(): void {
        // validate name
        if (this.d.name.length < 5 || this.d.name.length >= 255) {
            this.d.nameErr = true;
        } else {
            this.d.nameErr = false;
        }
    }

    public validateEmailInput(): void {
        // validate email
        if (this.d.email.length < 5 || !this.validateEmail(this.d.email)) {
            this.d.emailErr = true;
        } else {
            this.d.emailErr = false;
        }
    }

    public validateMessage(): void {
        // validate message
        if (this.d.message.length < 10) {
            this.d.messErr = true;
        } else {
            this.d.messErr = false;
        }
    }

    public resetErr () : void
    {
        this.d.nameErr = this.d.emailErr = this.d.messErr = this.d.commErr = this.d.commenting = null;
    }

    public resetForm () : void
    {
        this.d.name = this.d.email = this.d.message = ''

        this.resetErr()
    }

    public commentSend() {
        // first rest all errors
        this.resetErr()

        this.validateName();
        this.validateEmailInput();
        this.validateMessage();

        if (
            false === this.d.nameErr &&
            false === this.d.emailErr &&
            false === this.d.messErr
        ) {
            // send comment
            this.d.commenting = true;

            let form = new FormData();
            form.append("name", this.d.name);
            form.append("email", this.d.email);
            form.append("message", this.d.message);
            form.append("csrfToken", this.csrfToken);
            // @ts-ignore
            form.append('postId', this.postID)
            
            Axios.post('/api/sendComment', form)
                .then(res => {
                    if (res.data) {
                        let r = res.data
                        if (r.name) this.d.nameErr = true;
                        else if (r.email) this.d.emailErr = true;
                        else if (r.message) this.d.messErr = true;
                        else if (r.done) {
                            this.d.commErr = false
                            this.resetForm()
                        }
                    }
                })
                .catch(err => {
                    this.d.commErr = true
                })
                .finally(() => {
                    this.d.commenting = false
                })
        }
    }

    mounted() {
        // @ts-ignore
        // attach csrf_token to variable
        this.csrfToken = this.$root.$refs.csrf_token.value;
        // @ts-ignore
        this.postID = this.$root.$refs.postID.value

        // set all to allow parent to use it
        this.d = setSlotData(
            this,
            "commentSend",
            "validateName",
            "validateEmailInput"
        ) as this;

        // load comments from database
        Axios.post('/api/comments/', {
            csrfToken: this.csrfToken,
            postId: this.postID
        }).then(res => console.log(res))
        .catch(err => console.log(err))
    }
}
