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
                    <a href="#">{{ question.title }}</a>
                </h3>
                <div class="ml-auto">
                    <a
                        href="#"
                        v-if="authorize('modify', question)"
                        class="btn btn-outline-info btn-sm"
                        >Edit</a
                    >
                    <form
                        v-if="authorize('deleteQuestion', question)"
                        action="#"
                        method="POST"
                        class="d-inline"
                    >
                        <button
                            class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('Are you sure?')"
                        >
                            Delete
                        </button>
                    </form>
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
export default {
    props: ["question"],
    computed: {
        statusClasses() {
            return ["status", this.question.status];
        }
    },
    methods: {
        str_plural(str, count) {
            return str + (count > 1 ? "s" : "");
        }
    }
};
</script>

<style></style>
