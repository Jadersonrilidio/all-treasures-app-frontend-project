<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component :title="card.title" :components="card.components">
                    
                    <template v-slot:body>

                        <stash-card-component v-for="stash, i in stashes" :key="i"
                            :stash="stash"
                        >

                        </stash-card-component>


                        <!-- <pre>
                            {{ stashes }}
                        </pre> -->

                    </template>

                    <template v-slot:footer>
                        <button type="submit" class="btn btn-primary btn-sm" style="float:right">Add Stash</button>
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
                    title: 'Your Stashes',
                    components: {
                        header: true,
                        body: true,
                        footer: true
                    }
                },
                stashes: [
                    {table_show: false, show: false, id: '1', user_id: '1', title: 'stash 01', topic: 'demo', description: 'collection of demo', artifacts: [
                    {id: '1', title: 'artifact 01', stash_id: '1', tags: ['demo']},
                    {id: '2', title: 'artifact 02', stash_id: '1', tags: ['demo']},
                    {id: '3', title: 'artifact 03', stash_id: '1', tags: ['demo']},
                    {id: '4', title: 'artifact 04', stash_id: '1', tags: ['demo']},
                    {id: '5', title: 'artifact 05', stash_id: '1', tags: ['demo']},
                ]},
                    {table_show: false, show: false, id: '4', user_id: '1', title: 'stash 04', topic: 'pokemon', description: 'collection of pokemon', artifacts: [
                    {id: '16', title: 'artifact 16', stash_id: '4', tags: ['pokemon']},
                    {id: '17', title: 'artifact 17', stash_id: '4', tags: ['pokemon']},
                    {id: '18', title: 'artifact 18', stash_id: '4', tags: ['pokemon']},
                ]},
                    {table_show: false, show: false, id: '5', user_id: '1', title: 'stash 05', topic: 'cards', description: 'collection of cards', artifacts: [
                    {id: '20', title: 'artifact 20', stash_id: '5', tags: ['cards']},
                    {id: '21', title: 'artifact 21', stash_id: '5', tags: ['cards']},
                    {id: '22', title: 'artifact 22', stash_id: '5', tags: ['cards']},
                    {id: '23', title: 'artifact 23', stash_id: '5', tags: ['cards']},
                    {id: '24', title: 'artifact 24', stash_id: '5', tags: ['cards']},
                    {id: '25', title: 'artifact 25', stash_id: '5', tags: ['cards']},
                    {id: '26', title: 'artifact 26', stash_id: '5', tags: ['cards']},
                    {id: '27', title: 'artifact 27', stash_id: '5', tags: ['cards']},
                ]},
                ]
            }
        },
        methods: {
            // loadStashes() {
            //     let url = 'http://alltreasures.herokuapp.com/stashes/all-stashes/' + this.userid;

            //     let config = {
            //         headers: {
            //             'Accept': 'application/json',
            //         }
            //     }

            //     axios.get(url, config)
            //         .then(response => {
            //             console.log(response);
            //             this.stashes = response.data;
            //         })
            //         .catch(errors => {
            //             console.log(errors);
            //         });
            // }
        },
        mounted() {
            // this.loadStashes();
        },
    }
</script>
