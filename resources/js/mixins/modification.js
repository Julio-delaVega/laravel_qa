import Vote from "../components/Vote";
import UserInfo from "../components/UserInfo";
import MEditor from "../components/MEditor";
import highlight from "./highlight";
import destroy from "./destroy";

export default {
    mixins: [highlight, destroy],
    components: { Vote, UserInfo, MEditor },
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
        restoreFromCache() {}
    }
};
