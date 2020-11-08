<template>
    <div>
        <div class="card-body">
            <spinner v-if="$root.loading"></spinner>
            <div v-else-if="questions.length">
                <question-excerpt
                    v-for="question in questions"
                    :question="question"
                    :key="question.id"
                ></question-excerpt>
            </div>
            <div v-else class="alert alert-warning">
                <strong>Sorry!</strong> There are no questions available.
            </div>
            <!-- pagination -->
        </div>
        <!-- card-body -->
        <div class="card-footer">
            <pagination :meta="meta" :links="links"></pagination>
        </div>
    </div>
</template>

<script>
import Pagination from "../Pagination";
import QuestionExcerpt from "./QuestionExcerpt";
import EventBus from "../eventbus";
export default {
    components: {
        Pagination,
        QuestionExcerpt
    },
    data() {
        return {
            questions: [],
            meta: {},
            links: {}
        };
    },
    mounted() {
        this.fetchQuestions();
        EventBus.$on("deleted", id => {
            var index = this.questions.findIndex(q => q.id === id);
            this.remove(index);
        });
    },
    methods: {
        fetchQuestions() {
            axios.get("/questions", { params: this.$route.query }).then(res => {
                this.questions = res.data.data;
                this.meta = res.data.meta;
                this.links = res.data.links;
            });
        },
        remove(index) {
            this.questions.splice(index, 1);
            // this.count--;
        }
    },
    watch: {
        $route() {
            this.fetchQuestions();
        }
    }
};
</script>
