<template>
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#write"
                        >Write</a
                    >
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#preview"
                        >Preview</a
                    >
                </li>
            </ul>
        </div>
        <!-- card-header -->
        <div class="card-body tab-content">
            <div id="write" class="tab-pane active"><slot></slot></div>
            <!-- #write -->
            <div id="preview" class="tab-pane" v-html="preview"></div>
            <!-- #preview -->
        </div>
        <!-- card-body -->
    </div>
    <!-- card -->
</template>

<script>
import MarkdownIt from "markdown-it";
import Autosize from "autosize";
const md = new MarkdownIt();
export default {
    props: ["body"],
    computed: {
        preview() {
            return md.render(this.body);
        }
    },
    mounted() {
        Autosize(this.$el.querySelector("textarea"));
    },
    watch: {
        body() {
            Autosize(this.$el.querySelector("textarea"));
            console.log("New body");
        }
    }
};
</script>

<style></style>
