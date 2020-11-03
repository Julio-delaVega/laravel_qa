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
            <div id="preview" class="tab-pane">Preview...</div>
        </div>
        <!-- card-body -->
    </div>
    <!-- card -->
</template>

<script>
export default {
    props: ["body"]
};
</script>

<style></style>
