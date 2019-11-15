import Vue, { VNode } from "vue";
// import Component from "vue-class-component";
import VueScrollTo from 'vue-scrollto'
import Axios from "axios";
import textWriter from "./components/textWriter";
import animatedDots from "./components/animatedDots";
import Progress from "./components/Progress";
import Card from "./components/Card";
import Alert from "./components/Alert";
import { al } from "./partials/help";

Vue.config.productionTip = false;

// Vue.use(VueScrollTo)

Vue.use(VueScrollTo, {
    duration: 1000,
    offset: -60
})

Vue.component("alert", Alert);
Vue.component("animated-job-title", textWriter);
Vue.component("animated-dots", animatedDots);
Vue.component("dync-progress", Progress);
Vue.component("card", Card);

let app = new Vue({
    el: ".landing-page",
    data: {
        csrfToken: "",
        name: "",
        email: "",
        message: "",
        nameErr: null,
        emailErr: null,
        messErr: null,
        mailErr: null
    },
    methods: {
        validateEmail(email: string): boolean {
            let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        },
        resetErr () {
            this.nameErr = this.emailErr = this.messErr= this.mailErr = null;
        },
        resetForm() {
            this.name = this.email = this.message = ''
            this.resetErr()
        },
        sendMail(): void {
            // reset
            this.resetErr()

            // show validation result
            this.$refs.mailForm.classList.add("was-validated");

            // showloader
            this.$refs.sendMailLoader.classList.remove("d-none");

            if (this.name.length < 3 || this.name.length > 120) {
                this.nameErr = true;
            }
            if (
                this.email.length < 3 ||
                !this.validateEmail(this.email)
            ) {
                this.emailErr = true;
            }
            if (this.message.length < 5) {
                this.messErr = true;
            }

            // if all validation was successuffly
            if (
                null === this.nameErr &&
                null === this.emailErr &&
                null === this.messErr
            ) {
                let form = new FormData();
                form.append("name", this.name);
                form.append("email", this.email);
                form.append("message", this.message);
                form.append("csrfToken", this.csrfToken);

                Axios.post("/api/sendMail", form)
                    .then((res: any) => {
                        this.$refs.mailForm.classList.remove("was-validated");
                        // console.log(res);
                        let code = res.data.code
                        if (code) {
                            this.nameErr = code === 601 ? true : false
                            this.emailErr = code === 602 ? true : false
                            this.messErr = code === 603 ? true : false
                            
                            if (code === 200) {
                                this.resetForm()
                                return this.mailErr = false
                            }
                        }

                        // an error
                        this.mailErr = true
                    })
                    .catch(err => {
                        // console.log(err);
                        this.mailErr = true
                    })
                    .finally(() => {
                        this.$refs.sendMailLoader.classList.add("d-none");
                    });
            } else {
                this.$refs.sendMailLoader.classList.add("d-none");
            }
        },
        scrollTo (ev) {
            let target = document.querySelector(ev.target.getAttribute('href')),
            offset = target.offsetTop

            
        }
    },
    mounted() {
        // attach csrf_token to variable
        this.csrfToken = this.$refs.csrf_token.value + '55';

        // change navbar background on scroll
        document.addEventListener("scroll", ev => {
            let doc = document.documentElement as HTMLElement,
                navbar = document.querySelector(".navbar") as HTMLElement;

            if (doc.scrollTop > 300) {
                navbar.classList.remove("bg-transparent")
                navbar.classList.add('position-sticky')
            } else {
                navbar.classList.add("bg-transparent")
                navbar.classList.remove('position-sticky')
            }
        });
    }
});
