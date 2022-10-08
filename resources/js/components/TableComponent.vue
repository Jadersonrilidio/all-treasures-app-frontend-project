<template>
    <table class="table table-hover">
        <thead>
            <tr scope="row">
                <th scope="col" v-for="column, i in columns" :key="i">
                    {{ column }}
                </th>

                <th scope="col" v-for="button, j in buttons" :key="j">
                    {{ button.title }}
                </th>
            </tr>
        </thead>

        <tbody>
            <tr scope="row" v-for="item, key in items" :key="key">
                <td :scope="(attr == 'id') ? 'col' : ''" v-for="value, attr in item" :key="attr">
                    {{ value }}
                </td>
                
                <td v-for="button, k in buttons" :key="k">
                    <a class="btn btn-sm" :class="'btn-outline-'+button.class" href="#">
                        {{ button.title }}
                    </a>
                </td>
            </tr>

            <slot name="rows"></slot>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: [
            'columns',
            'buttons',
            'items',
        ],
    }
</script>
