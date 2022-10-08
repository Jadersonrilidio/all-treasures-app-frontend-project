<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component :title="card.title" :components="card.components">
                    
                    <template v-slot:body>
                        <table-component>

                        </table-component>
                    </template>

                    <template v-slot:footer>
                        <button type="submit" class="btn btn-primary btn-sm" style="float:right">Add Topic</button>
                    </template>

                </card-component>

            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

    export default {
        props: [
            'username',
            'userid'
        ],
        data() {
            return {
                topics: [],
               card: {
                title: 'Topics list',
                components: {
                    header: true,
                    body: true,
                    footer: true
                }
               }
            }
        },
        methods: {
            loadTopics() {
                let url = 'http://alltreasures.herokuapp.com/topic/all-topics';

                let config = {
                    headers: {
                        'Accept': 'application/json',
                    }
                }

                axios.get(url, config)
                    .then(response => {
                        console.log(response);
                        this.topics = response.data;
                    })
                    .catch(errors => {
                        console.log(errrors);
                    });
            }
        },
        mounted() {
            this.loadTopics();
        },
    }
</script>
