<script>
export default {
    props: ["answer"],
    data() {
        return {
            editing: false,
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            id: this.answer.id,
            questionId: this.answer.question_id,
            beforeEditCache: null
        };
    },
    computed: {
        isInvalid() {
            return this.body.length < 10;
        },
        endpoint() {
            return `/questions/${this.questionId}/answers/${this.id}`;
        }
    },
    methods: {
        edit() {
            this.beforeEditCache = this.body;
            this.editing = true;
        },
        update() {
            axios
                .patch(this.endpoint, {
                    body: this.body
                })
                .then(res => {
                    this.bodyHtml = res.data.body_html;
                    this.editing = false;
                    alert(res.data.message);
                })
                .catch(err => {
                    console.log(err.response);
                    alert(err.response.data.message);
                    console.log("Something went wrong!");
                });
        },
        cancel() {
            this.body = this.beforeEditCache;
            this.editing = false;
        },
        destroy() {
            if (confirm("Are you sure?")) {
                axios.delete(this.endpoint).then(res => {
                    $(this.$el).fadeOut(500, () => {
                        alert(res.data.message);
                    });
                });
            }
        }
    }
};
</script>
