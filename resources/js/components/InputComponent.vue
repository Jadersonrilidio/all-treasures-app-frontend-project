<template>
    <div class="form-group" :class="classes">
        <label :for="id" class="col-md-4 col-form-label text-md-end"> {{ title }} </label>

        <div class="col-md-6">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'classes',
            'id',
            'title'
        ]
    }
</script>
