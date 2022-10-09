<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component :title="card.title" :components="card.components">
                    <template v-slot:header>
                        <button type="submit" class="btn btn-primary btn-sm" style="float:right" data-toggle="modal" :data-target="'#'+modalAdd.id">Add Stash</button>
                    </template>

                    <template v-slot:body>
                        <stash-card-component v-for="stash, i in stashes" :key="i"
                            :stash="stash"
                        >
                        </stash-card-component>
                    </template>

                    <template v-slot:footer>
                        <button type="submit" class="btn btn-primary btn-sm" style="float:right" data-toggle="modal" :data-target="'#'+modalAdd.id">Add Stash</button>
                    </template>
                </card-component>

            </div>
        </div>

        <modal-component :id="modalAdd.id" :title="modalAdd.title">
            <template v-slot:alerts>
                <alert-component>

                </alert-component>
            </template>

            <template v-slot:content>
                <input-component classes="row mb-3" id="stashTitle" title="Title">
                    <input id="stashTitle" type="text" name="stashTitle" class="form-control" required autofocus v-model="stashTitle">
                </input-component>
        
                <input-component classes="row mb-3" id="stashTopic" title="Topic">
                    <select name="stashTopic" id="">
                        <option value="" selected> Select a topic: </option>
                        <option :value="topic.id" v-for="topic, key in topics" :key="key">
                            {{ topic.title }}
                        </option>
                    </select>
                    <input id="stashTopic" type="number" name="stashTopic" class="form-control" required autofocus v-model="stashTopic">
                </input-component>

                <input-component classes="row mb-3" id="stashDescription" title="description">
                    <input id="stashDescription" type="text" name="stashDescription" class="form-control" required autofocus v-model="stashDescription">
                </input-component>
            </template>
            
            <template v-slot:footer>
                <button type="submit" class="btn btn-secondary btn-sm" style="float:right" data-dismiss="modal" @click="cleanNewStashData()">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm" style="float:right" @click="addStash()">Add</button>
            </template>
        </modal-component>

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
                // stashes: [],
                topics: [],
                stashTitle: '',
                stashTopic: '',
                stashDescription: '',
                card: {
                    title: 'Your Stashes',
                    components: {
                        header: true,
                        body: true,
                        footer: true
                    }
                },
                modalAdd: {
                    id: 'addStashModal',
                    title: 'Add New Stash'
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
            //     let url = 'http://alltreasures.herokuapp.com' + '/stashes/all-stashes/' + this.userid;

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
            // },
            loadTopics() {
                let url = 'http://alltreasures.herokuapp.com' + '/topic/all-topics';

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
            },
            cleanNewStashData() {
                this.stashTitle = '',
                this.stashTopic = '',
                this.stashDescription = ''
            },
            addStash() {
                let url = 'http://alltreasures.herokuapp.com' + '/stash/create';

                let formData = new FormData();
                formData.append('user_id', this.userid);
                formData.append('title', this.stashTitle);
                formData.append('topic', this.stashTopic);
                formData.append('description', this.stashDescription);

                let config = {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                };

                axios.post(url, formData, config)
                    .then(response => {
                        console.log(response);
                        //Alert signals
                    })
                    .catch(errors => {
                        console.log(errors.response);
                    })
            }
        },
        mounted() {
            // this.loadStashes();
            this.loadTopics();
        },
    }
</script>
