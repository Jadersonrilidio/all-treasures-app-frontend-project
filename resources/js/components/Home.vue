<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component :title="cardTitle" :components="card.components">
                    <template v-slot:body>

                        <p>You are logged in!</p>
                        <h1>Dashboard here</h1>

                    </template>
                </card-component>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'username',
            'userid'
        ],
        data() {
            return {
               card: {
                components: {
                    header: true,
                    body: true,
                    footer: false
                }
               }
            }
        },
        methods: {

        },
        computed: {
            cardTitle() {
                return 'Welcome back, ' + this.username + '!';
            }
        },
        mounted() {

        },
    }
</script>
