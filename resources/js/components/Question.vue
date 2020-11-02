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
export default {
    components: { Vote, UserInfo },
    props: ["question"],
    data() {
        return {
            title: this.question.title,
            body: this.question.body,
            bodyHtml: this.question.body_html,
            editing: false,
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
        edit() {
            this.beforeEditCache = {
                body: this.body,
                title: this.title
            };
            this.editing = true;
        },
        cancel() {
            this.body = this.beforeEditCache.body;
            this.title = this.beforeEditCache.title;
            this.editing = false;
        },
        update() {
            axios
                .put(this.endpoint, {
                    body: this.body,
                    title: this.title
                })
                .then(res => {
                    this.bodyHtml = res.data.body_html;
                    this.$toast.success(res.data.message, "Success", {
                        timeout: 3000
                    });
                    this.editing = false;
                })
                .catch(err => {
                    this.$toast.error(err.response.data.message, "Error", {
                        timeout: 3000
                    });
                });
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
                                this.$toast.success(
                                    res.data.message,
                                    "Success",
                                    { timeout: 2000 }
                                );
                            });

                            setTimeout(() => {
                                window.location.href = "/questions";
                            }, 4000);

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

<style></style>
