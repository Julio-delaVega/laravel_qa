<template>
    <div class="media post">
        <vote :model="answer" name="answer"></vote>
        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea
                        rows="10"
                        class="form-control"
                        v-model="body"
                        required
                    ></textarea>
                </div>
                <!-- form-group -->
                <button
                    class="btn btn-outline-primary btn-sm"
                    type="submit"
                    :disabled="isInvalid"
                >
                    Update
                </button>
                <button
                    class="btn btn-outline-secondary btn-sm"
                    type="button"
                    @click.prevent="cancel"
                >
                    Cancel
                </button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            <a
                                v-if="authorize('modify', answer)"
                                @click.prevent="edit"
                                class="btn btn-outline-info btn-sm"
                                >Edit</a
                            >
                            <button
                                v-if="authorize('modify', answer)"
                                class="btn btn-outline-danger btn-sm"
                                @click="destroy"
                            >
                                Delete
                            </button>
                        </div>
                        <!-- ml-auto -->
                    </div>
                    <!-- col-4 -->
                    <div class="col-4"></div>
                    <!-- col-4 -->
                    <div class="col-4">
                        <user-info :model="answer" label="Answered"></user-info>
                    </div>
                    <!-- col-4 -->
                </div>
            </div>
        </div>
        <!-- media-body -->
    </div>
    <!-- media -->
</template>

<script>
import Vote from "./Vote";
import UserInfo from "./UserInfo";
export default {
    components: { Vote, UserInfo },
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
                    this.$toast.success(res.data.message, "Success", {
                        timeout: 3000
                    });
                })
                .catch(err => {
                    this.$toast.error(err.response.data.message, "Error", {
                        timeout: 3000
                    });
                });
        },
        cancel() {
            this.body = this.beforeEditCache;
            this.editing = false;
        },
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
                            axios.delete(this.endpoint).then(res => {
                                this.$emit("deleted");
                            });

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
        }
    }
};
</script>
