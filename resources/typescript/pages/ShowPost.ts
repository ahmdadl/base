import Vue from "vue";
import Component from "vue-class-component";
import setSlotData from "../partials/setSlotData";
import Axios from "axios";
import { create } from "domain";
import removePost from "../partials/removePost";

interface Comment {
    id: number;
    name: string;
    email: string;
    body: string;
    created_at: string;
    fresh?: boolean;
}

@Component({
    template: require("./template.html")
})
export default class ShowPost extends Vue {
    public d: this = this;
    public postID: null | number = null;
    public name = "";
    public email = "";
    public message = "";
    public nameErr: null | boolean = null;
    public emailErr: null | boolean = null;
    public messErr: null | boolean = null;
    public commErr: null | boolean = null;
    public commenting: null | boolean = null;
    public csrfToken = "";
    public allComments: null | Array<Comment> = null;
    public loading = false;

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

    public resetErr(): void {
        this.d.nameErr = this.d.emailErr = this.d.messErr = this.d.commErr = this.d.commenting = null;
    }

    public resetForm(): void {
        this.d.name = this.d.email = this.d.message = "";

        this.resetErr();
    }

    public addToComments(img: string, commentId: number): void {
        // @ts-ignore
        this.d.allComments.push({
            id: commentId,
            name: this.d.name,
            email: img,
            body: this.d.message,
            created_at: "now",
            fresh: true
        });
    }

    public commentSend() {
        // first rest all errors
        this.resetErr();

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
            form.append("postId", this.postID);

            Axios.post("/api/sendComment", form)
                .then(res => {
                    if (res.data) {
                        // console.log(res)
                        let r = res.data;
                        if (r.done) {
                            this.d.commErr = false;
                            this.addToComments(r.email, r.cid);
                            this.resetForm();
                        } else if (r.name) this.d.nameErr = true;
                        else if (r.email) this.d.emailErr = true;
                        else if (r.message) this.d.messErr = true;
                    }
                })
                .catch(err => {
                    this.d.commErr = true;
                })
                .finally(() => {
                    this.d.commenting = false;
                });
        }
    }

    public deletePost(pid, redirect = false) {
        removePost(this, pid, redirect);
    }

    public deleteComment(cid: number, inx: number) {
        console.log(cid, inx);
        let span = this.$root.$refs["commentDanger" + cid][0] as HTMLElement;

        span.classList.remove("d-none");

        Axios.delete("/api/comments/" + cid)
            .then(res => {
                // console.log(res);
                if (res && res.data) {
                    if (res.data.done) {
                        // @ts-ignore
                        this.d.allComments.splice(inx, 1);
                    } else {
                        console.log("an error occured");
                        console.log(res);
                    }
                }
            })
            .catch(err => console.log(err))
            .finally(() => span.classList.add("d-none"));
    }

    mounted() {
        // @ts-ignore
        // attach csrf_token to variable
        this.csrfToken = this.$root.$refs.csrf_token.value;
        // @ts-ignore
        this.postID = this.$root.$refs.postID.value;

        // set all to allow parent to use it
        this.d = setSlotData(
            this,
            "commentSend",
            "validateName",
            "validateEmailInput",
            "deletePost",
            "deleteComment"
        ) as this;

        // load comments from database
        // show loader
        this.d.loading = true;

        let form = new FormData();
        form.append("csrfToken", this.csrfToken);
        // @ts-ignore
        form.append("postId", this.postID);
        Axios.post("/api/allComments", form)
            .then(res => {
                // console.log(res);
                this.d.allComments = res.data;
            })
            .catch(err => {
                /* console.log(err) */
            })
            .finally(() => (this.d.loading = false));
    }
}
