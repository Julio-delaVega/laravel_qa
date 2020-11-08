<template>
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a
                        class="nav-link active"
                        data-toggle="tab"
                        :href="tabId('write', '#')"
                        >Write</a
                    >
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        data-toggle="tab"
                        :href="tabId('preview', '#')"
                        >Preview</a
                    >
                </li>
            </ul>
        </div>
        <!-- card-header -->
        <div class="card-body tab-content">
            <div :id="tabId('write')" class="tab-pane active">
                <slot></slot>
            </div>
            <!-- #write -->
            <div :id="tabId('preview')" class="tab-pane" v-html="preview"></div>
            <!-- #preview -->
        </div>
        <!-- card-body -->
    </div>
    <!-- card -->
</template>

<script>
import MarkdownIt from "markdown-it";
import prism from "markdown-it-prism";
import Autosize from "autosize";
const md = new MarkdownIt();
md.use(prism);
export default {
    props: ["body", "name"],
    computed: {
        preview() {
            return md.render(this.body);
        }
    },
    updated() {
        Autosize(this.$el.querySelector("textarea"));
    },
    methods: {
        tabId(tabName, hash = "") {
            return `${hash}${tabName}${this.name}`;
        }
    }
};
</script>
