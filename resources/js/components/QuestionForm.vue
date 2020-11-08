<template>
    <form @submit.prevent="handleSubmit">
        <div class="form-group">
            <label for="question-title">Question Title</label>
            <input type="text" :class="errorClass('title')" v-model="title" />

            <div v-if="errors['title'][0]" class="invalid-feedback">
                <strong>{{ errors["title"][0] }}</strong>
            </div>
            <!-- invalid-feedback -->
        </div>
        <!-- form-group -->
        <div class="form-group">
            <label for="question-body">Explain your question</label>
            <m-editor :body="body" name="question-body">
                <textarea
                    :class="errorClass('body')"
                    rows="10"
                    v-model="body"
                ></textarea>
                <div v-if="errors['body'][0]" class="invalid-feedback">
                    <strong>{{ errors["body"][0] }}</strong>
                </div>
                <!-- invalid-feedback -->
            </m-editor>
        </div>
        <!-- form-group -->
        <div class="form-group">
            <button type="submit" class="btn btn-outline-primary btn-lg">
                {{ buttonText }}
            </button>
        </div>
        <!-- form-group -->
    </form>
</template>

<script>
import EventBus from "../eventbus";
import MEditor from "./MEditor";
export default {
    components: { MEditor },
    props: {
        isEdit: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            title: "",
            body: "",
            errors: {
                title: [],
                body: []
            }
        };
    },
    computed: {
        buttonText() {
            return this.isEdit ? "Update Question" : "Ask Question";
        }
    },
    mounted() {
        EventBus.$on("error", errors => (this.errors = errors));
        if (this.isEdit) {
            this.fetchQuestion();
        }
    },
    methods: {
        fetchQuestion() {
            axios
                .get(`/questions/${this.$route.params.id}`)
                .then(res => {
                    this.title = res.data.title;
                    this.body = res.data.body;
                })
                .catch(err => {
                    console.log(err.response);
                });
        },
        errorClass(column) {
            return [
                "form-control",
                this.errors[column] && this.errors[column][0]
                    ? "is-invalid"
                    : ""
            ];
        },
        handleSubmit() {
            this.$emit("submitted", { title: this.title, body: this.body });
        }
    }
};
</script>
