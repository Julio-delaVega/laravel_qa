<template>
    <div class="spinner" :style="minWidthStyle">
        <i class="fa fa-spinner fa-spin" :class="sizeClass"></i>
    </div>
</template>

<script>
export default {
    props: {
        small: {
            type: Boolean,
            default: false
        },
        minWidth: {
            type: Number,
            default: 107.66
        }
    },
    computed: {
        sizeClass() {
            return this.small ? "" : "fa-3x";
        },
        minWidthStyle() {
            return {
                minWidth: `${this.minWidth}px`
            };
        }
    }
};
</script>

<style scoped>
.spinner {
    color: #ddd;
    text-align: center;
}
</style>
