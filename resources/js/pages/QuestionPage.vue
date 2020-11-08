<template>
    <div v-if="question.id" class="container">
        <question :question="question"></question>
        <answers :question="question"></answers>
    </div>
    <!-- container -->
</template>

<script>
import Question from "../components/Question";
import Answers from "../components/Answers";
export default {
    components: {
        Question,
        Answers
    },
    props: ["slug"],
    data() {
        return {
            question: {}
        };
    },
    mounted() {
        this.fetchQuestion();
    },
    methods: {
        fetchQuestion() {
            axios
                .get(`/questions/${this.slug}`)
                .then(res => {
                    this.question = res.data.data;
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
};
</script>
