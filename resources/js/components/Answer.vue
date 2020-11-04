<template>
    <div class="media post">
        <vote :model="answer" name="answer"></vote>
        <div class="media-body">
            <form
                v-show="authorize('modify', answer) && editing"
                @submit.prevent="update"
            >
                <div class="form-group">
                    <m-editor :body="body" :name="uniqueName">
                        <textarea
                            rows="10"
                            class="form-control"
                            v-model="body"
                            required
                        ></textarea>
                    </m-editor>
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
            <div v-show="!editing">
                <div ref="bodyHtml" v-html="bodyHtml"></div>
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
import modification from "../mixins/modification";

export default {
    props: ["answer"],
    mixins: [modification],
    data() {
        return {
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
        },
        uniqueName() {
            return `answer-${this.id}`;
        }
    },
    mounted() {
        this.highlight();
    },
    methods: {
        setEditCache() {
            this.beforeEditCache = this.body;
        },
        payload() {
            return { body: this.body };
        },
        restoreFromCache() {
            this.body = this.beforeEditCache;
        },
        delete() {
            axios.delete(this.endpoint).then(res => {
                this.$emit("deleted");
                this.$toast.success(res.data.message, "Success", {
                    timeout: 2000
                });
            });
        }
    }
};
</script>
