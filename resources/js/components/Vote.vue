<template>
    <div class="d-flex flex-column vote-controls">
        <a
            :title="title('up')"
            class="vote-up"
            :class="classes"
            @click.prevent="voteUp"
        >
            <i class="fas fa-caret-up fa-3x"></i>
        </a>

        <span class="votes-count">
            {{ count }}
        </span>
        <a
            :title="title('down')"
            class="vote-down"
            :class="classes"
            @click.prevent="voteDown"
        >
            <i class="fas fa-caret-down fa-3x"></i>
        </a>

        <favorite v-if="name == 'question'" :question="model"></favorite>
        <accept-best v-else-if="name == 'answer'" :answer="model"></accept-best>
    </div>
</template>

<script>
import Favorite from "./Favorite";
import AcceptBest from "./AcceptBest";
export default {
    components: {
        Favorite,
        AcceptBest
    },
    props: ["name", "model"],
    data() {
        return {
            count: this.model.votes_count || 0,
            id: this.model.id
        };
    },
    computed: {
        classes() {
            return this.signedIn ? "" : "off";
        },
        endpoint() {
            return `/${this.name}s/${this.id}/vote`;
        }
    },
    methods: {
        title(voteType) {
            var titles = {
                up: `This ${this.name} is useful`,
                down: `This ${this.name} is not useful`
            };
            return titles[voteType];
        },
        voteUp() {
            this._vote(1);
        },
        voteDown() {
            this._vote(-1);
        },
        _vote(vote) {
            if (!this.signedIn) {
                this.$toast.warning(
                    `Please sign in to vote the ${this.name}`,
                    "Warning",
                    {
                        timeou: 3000,
                        position: "bottomLeft"
                    }
                );
                return;
            }
            axios.post(this.endpoint, { vote }).then(res => {
                this.$toast.success(res.data.message, "Success", {
                    timeout: 3000,
                    position: "bottomLeft"
                });
                this.count = res.data.votes_count;
            });
        }
    }
};
</script>

<style></style>
