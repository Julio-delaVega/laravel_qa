<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>Ask Question</h2>
                            <div class="ml-auto">
                                <router-link
                                    :to="{ name: 'questions' }"
                                    class="btn btn-outline-secondary"
                                    >Go Back</router-link
                                >
                            </div>
                        </div>
                    </div>
                    <!-- card-header -->
                    <div class="card-body">
                        <question-form @submitted="create"></question-form>
                    </div>
                    <!-- card-body -->
                </div>
                <!-- card -->
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
    <!-- container -->
</template>

<script>
import QuestionForm from "../components/QuestionForm";
import EventBus from "../eventbus";
export default {
    components: {
        QuestionForm
    },
    methods: {
        create(data) {
            axios
                .post("/questions", data)
                .then(res => {
                    this.$router.push({ name: "questions" });
                    this.$toast.success(res.data.message, "Success");
                })
                .catch(err => {
                    EventBus.$emit("error", err.response.data.errors);
                    console.log(err.response.data.errors);
                });
        }
    }
};
</script>

<style></style>
