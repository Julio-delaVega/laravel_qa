<template>
    <div class="media post">
        <div class="counters d-flex flex-column">
            <div class="vote">
                <strong>{{ question.votes_count }}</strong>
                {{ str_plural("vote", question.votes_count) }}
            </div>
            <!-- vote -->
            <div :class="statusClasses">
                <strong>{{ question.answers_count }}</strong>
                {{ str_plural("answer", question.answers_count) }}
            </div>
            <!-- status -->
            <div class="view">
                {{ question.views }} {{ str_plural("view", question.views) }}
            </div>
            <!-- view -->
        </div>
        <!-- counters -->
        <div class="media-body">
            <div class="d-flex align-items-center">
                <h3 class="mt-0">
                    <router-link
                        :to="{
                            name: 'questions.show',
                            params: { slug: question.slug }
                        }"
                        >{{ question.title }}</router-link
                    >
                </h3>
                <div class="ml-auto">
                    <router-link
                        v-if="authorize('modify', question)"
                        :to="{
                            name: 'questions.edit',
                            params: { id: question.id }
                        }"
                        class="btn btn-outline-info btn-sm"
                        >Edit</router-link
                    >
                    <button
                        v-if="authorize('deleteQuestion', question)"
                        class="btn btn-outline-danger btn-sm"
                        @click="destroy"
                    >
                        Delete
                    </button>
                </div>
                <!-- ml-auto -->
            </div>
            <!-- d-flex -->
            <p class="lead">
                Asked by
                <a href="#">{{ question.user.name }}</a>
                <small class="text-muted">{{ question.created_date }}</small>
            </p>
            <div class="excerpt">
                {{ question.excerpt }}
            </div>
            <!-- excerpt -->
        </div>
        <!-- media-body -->
    </div>
    <!-- media -->
</template>

<script>
import destroy from "../mixins/destroy";
import EventBus from "../eventbus";
export default {
    props: ["question"],
    mixins: [destroy],
    computed: {
        statusClasses() {
            return ["status", this.question.status];
        }
    },
    methods: {
        str_plural(str, count) {
            return str + (count > 1 ? "s" : "");
        },
        delete() {
            this.$root.disableInterceptor();
            axios.delete(`/questions/${this.question.id}`).then(res => {
                this.$toast.success(res.data.message, "Success", {
                    timeout: 2000
                });
                EventBus.$emit("deleted", this.question.id);
                // this.$emit("deleted");
            });
        }
    }
};
</script>
