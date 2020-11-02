<template>
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
                        v-for="answer in answers"
                        :answer="answer"
                        :key="answer.id"
                    ></answer>
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
import Answer from "./Answer";
export default {
    components: {
        Answer
    },
    props: ["answers", "count"],
    computed: {
        title() {
            return this.count + " " + (this.count > 1 ? "Answers" : "Answer");
        }
    }
};
</script>
