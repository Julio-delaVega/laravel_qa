<template>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Your Answer</h3>
                    </div>
                    <!-- cart-title -->
                    <hr />
                    <form @submit.prevent="create">
                        <div class="form-group">
                            <m-editor :body="body" name="new-answer">
                                <textarea
                                    name="body"
                                    rows="7"
                                    class="form-control"
                                    v-model="body"
                                    required
                                ></textarea>
                            </m-editor>
                        </div>
                        <!-- form-group -->
                        <div class="form-group">
                            <button
                                type="submit"
                                :disabled="isInvalid"
                                class="btn btn-lg btn-outline-primary"
                            >
                                Submit
                            </button>
                        </div>
                        <!-- form-group -->
                    </form>
                </div>
                <!-- cart-body -->
            </div>
            <!-- cart -->
        </div>
        <!-- col -->
    </div>
    <!-- row -->
</template>

<script>
import MEditor from "./MEditor";
export default {
    components: { MEditor },
    props: ["questionId"],
    data() {
        return {
            body: ""
        };
    },
    computed: {
        isInvalid() {
            return !this.signedIn || this.body.length < 10;
        }
    },
    methods: {
        create() {
            axios
                .post(`/questions/${this.questionId}/answers`, {
                    body: this.body
                })
                .then(res => {
                    this.$toast.success(res.data.message, "Success");
                    this.body = "";
                    this.$emit("created", res.data.answer);
                })
                .catch(err => {
                    this.$toast.error(err.response.data.message, "Error");
                });
        }
    }
};
</script>
