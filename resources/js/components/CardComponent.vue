<template>
    <div class="card">
        <div class="card-header" v-if="components.header">
            {{ title }}
            <slot name="header"></slot>
        </div>

        <div class="card-body" v-if="components.body">

            <slot name="body"></slot>
        </div>

        <div class="card-footer" v-if="components.footer">

            <slot name="footer"></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'title',
            'components'
        ]
    }
</script>
