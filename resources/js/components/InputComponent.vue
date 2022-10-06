<template>
    <div class="form-group" :class="classes">
        <label for="email" class="col-md-4 col-form-label text-md-end"> {{ title }} </label>

        <div class="col-md-6">
            <input id="email" type="email" class="form-control" value="" required autofocus>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'classes',
            'title',
            'input',
        ],
    }
</script>
