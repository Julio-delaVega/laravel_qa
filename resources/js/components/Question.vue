<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <form v-if="editing" class="card-body" @submit.prevent="update">
                    <div class="card-title">
                        <input
                            type="text"
                            class="form-control form-control-lg"
                            v-model="title"
                        />
                    </div>
                    <!-- card-title -->
                    <hr />
                    <div class="media">
                        <div class="media-body">
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
                        </div>
                        <!-- media body -->
                    </div>
                    <!-- media -->
                </form>
                <!-- card-body -->
                <div v-else class="card-body">
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h1>{{ title }}</h1>
                            <div class="ml-auto">
                                <a
                                    href="/questions"
                                    class="btn btn-outline-secondary"
                                    >Go Back</a
                                >
                            </div>
                        </div>
                    </div>
                    <!-- card-title -->
                    <hr />
                    <div class="media">
                        <vote :model="question" name="question"></vote>
                        <div class="media-body">
                            <div v-html="bodyHtml"></div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="ml-auto">
                                        <a
                                            v-if="authorize('modify', question)"
                                            @click.prevent="edit"
                                            class="btn btn-outline-info btn-sm"
                                            >Edit</a
                                        >
                                        <button
                                            v-if="
                                                authorize(
                                                    'deleteQuestion',
                                                    question
                                                )
                                            "
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
                                    <user-info
                                        :model="question"
                                        label="Asked"
                                    ></user-info>
                                </div>
                            </div>
                        </div>
                        <!-- media body -->
                    </div>
                    <!-- media -->
                </div>
                <!-- card-body -->
            </div>
            <!-- card -->
        </div>
        <!-- col -->
    </div>
    <!-- row -->
</template>

<script>
import Vote from "./Vote";
import UserInfo from "./UserInfo";
import modification from "../mixins/modification";

export default {
    components: { Vote, UserInfo },
    props: ["question"],
    mixins: [modification],
    data() {
        return {
            title: this.question.title,
            body: this.question.body,
            bodyHtml: this.question.body_html,
            id: this.question.id,
            beforeEditCache: {}
        };
    },
    computed: {
        isInvalid() {
            return (
                !this.signedIn ||
                this.body.length < 10 ||
                this.title.length < 10
            );
        },
        endpoint() {
            return `/questions/${this.id}`;
        }
    },
    methods: {
        setEditCache() {
            this.beforeEditCache = {
                body: this.body,
                title: this.title
            };
        },
        restoreFromCache() {
            this.body = this.beforeEditCache.body;
            this.title = this.beforeEditCache.title;
        },
        payload() {
            return {
                body: this.body,
                title: this.title
            };
        },
        delete() {
            axios.delete(this.endpoint).then(res => {
                this.$toast.success(res.data.message, "Success", {
                    timeout: 2000
                });
            });

            setTimeout(() => {
                window.location.href = "/questions";
            }, 4000);
        }
    }
};
</script>

<style></style>
