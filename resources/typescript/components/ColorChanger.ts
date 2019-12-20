import Vue from "vue";
import Component from "vue-class-component";

@Component({
    props: {
        type: {
            type: String,
            required: true
        },
        target: {
            type: String,
            required: true
        }
    },
    template: `
        <button
            class="btn btn-sm rounded mx-2 pt-0 changeTheme"
            :class="['btn-' + type, {active: type === 'dark'}]"
            :type="target"
            @click="updateColor"
        >
            &nbsp;
        </button>
    `
})
export default class ColorChanger extends Vue {
    public updateColor() {
        let type = this.$props.type,
            target = this.$props.target;

        if (type === "dark" || type === "light") {
            // @ts-ignore
            document
                .querySelectorAll(
                    `.actual-page.bg-${target}, .actual-page .bg-${target}, .actual-page .bg-${type}, .sidenav.bg-dark, .sidenav.bg-secondary`
                )
                .forEach(bg => {
                    document.body.classList.replace(
                        `bg-${target}`,
                        `bg-${type}`
                    );
                    document.body.classList.replace(
                        `text-${type}`,
                        `text-${target}`
                    );

                    let eleClass = bg.classList;

                    if (eleClass.contains("sidenav")) {
                        if (eleClass.contains("bg-dark") && type === "dark") {
                            eleClass.replace("bg-dark", "bg-secondary");
                            eleClass.replace("text-white-50", "text-black-50");
                        } else {
                            eleClass.replace("bg-secondary", "bg-dark");
                            eleClass.replace("text-black-50", "text-white-50");
                        }
                    } else {
                        eleClass.replace(`bg-${target}`, `bg-${type}`);
                        eleClass.replace(`text-${type}`, `text-${target}`);
                    }

                    if (
                        bg.nodeName === "HR" ||
                        bg.classList.contains("align-middle") ||
                        eleClass.contains("list-group-item")
                    ) {
                        eleClass.replace(`bg-${type}`, `bg-${target}`);
                        eleClass.replace(`text-${target}`, `text-${type}`);
                    }
                });
        } else {
            // @ts-ignore
            for (const pr of document.querySelectorAll(
                `.actual-page .btn,.actual-page .bg-${target}, .actual-page .text-${target}, .actual-page .badge-${target}, .navbar.bg-${target}, .border-${target}`
            )) {
                if (!pr.classList.contains("noColor")) {
                    pr.classList.replace(`btn-${target}`, `btn-${type}`);
                    pr.classList.replace(
                        `btn-outline-${target}`,
                        `btn-outline-${type}`
                    );
                    pr.classList.replace(`bg-${target}`, `bg-${type}`);
                    pr.classList.replace(`text-${target}`, `text-${type}`);
                    pr.classList.replace(`badge-${target}`, `badge-${type}`);
                    pr.classList.replace(`border-${target}`, `border-${type}`);
                }
            }
        }
    }
}
