import Prism from "prismjs";

export default {
    methods: {
        highlight() {
            var el = this.$refs.bodyHtml;
            if (el) {
                Prism.highlightAllUnder(el);
            }
        }
    }
};
