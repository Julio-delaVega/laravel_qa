<template>
    <div>
        <div class="row mt-4" v-cloak v-if="count">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h2>{{ title }}</h2>
                        </div>
                        <!-- card-title -->
                        <hr />
                        <answer
                            v-for="(answer, index) in answers"
                            :answer="answer"
                            :key="answer.id"
                            @deleted="remove(index)"
                        ></answer>
                        <div v-if="nextUrl" class="text-center mt-3">
                            <button
                                class="btn btn-outline-secondary"
                                @click.prevent="fetch(nextUrl)"
                            >
                                Load more answers
                            </button>
                        </div>
                    </div>
                    <!-- card-body -->
                </div>
                <!-- card -->
            </div>
            <!-- col -->
        </div>
        <!-- row -->
        <new-answer :question-id="question.id" @created="add"></new-answer>
    </div>
</template>

<script>
import Answer from "./Answer";
import NewAnswer from "./NewAnswer";
export default {
    components: {
        Answer,
        NewAnswer
    },
    props: ["question"],
    data() {
        return {
            questionId: this.question.id,
            count: this.question.answers_count,
            answers: [],
            nextUrl: null
        };
    },
    computed: {
        title() {
            return this.count + " " + (this.count > 1 ? "Answers" : "Answer");
        }
    },
    created() {
        this.fetch(`/questions/${this.questionId}/answers`);
    },
    methods: {
        fetch(endpoint) {
            axios.get(endpoint).then(res => {
                this.answers.push(...res.data.data);
                this.nextUrl = res.data.next_page_url;
            });
        },
        add(answer) {
            this.answers.push(answer);
            this.count++;
        },
        remove(index) {
            this.answers.splice(index, 1);
            this.count--;
        }
    }
};
</script>
