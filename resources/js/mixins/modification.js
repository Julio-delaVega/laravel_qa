import highlight from "./highlight";

export default {
    mixins: [highlight],
    data() {
        return {
            editing: false
        };
    },
    methods: {
        edit() {
            this.setEditCache();
            this.editing = true;
        },
        update() {
            axios
                .patch(this.endpoint, this.payload())
                .then(res => {
                    this.bodyHtml = res.data.body_html;
                    this.editing = false;
                    this.$toast.success(res.data.message, "Success", {
                        timeout: 3000
                    });
                })
                .catch(err => {
                    this.$toast.error(err.response.data.message, "Error", {
                        timeout: 3000
                    });
                })
                .then(() => {
                    this.highlight();
                });
        },
        payload() {},
        cancel() {
            this.restoreFromCache();
            this.editing = false;
        },
        setEditCache() {},
        restoreFromCache() {},
        destroy() {
            this.$toast.question("Are you sure?", "Confirm", {
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: "once",
                id: "question",
                zindex: 999,
                position: "center",
                buttons: [
                    [
                        "<button><b>YES</b></button>",
                        (instance, toast) => {
                            this.delete();

                            instance.hide(
                                { transitionOut: "fadeOut" },
                                toast,
                                "button"
                            );
                        },
                        true
                    ],
                    [
                        "<button>NO</button>",
                        function(instance, toast) {
                            instance.hide(
                                { transitionOut: "fadeOut" },
                                toast,
                                "button"
                            );
                        }
                    ]
                ]
            });
        },
        delete() {}
    }
};
