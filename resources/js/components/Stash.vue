<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component :title="card.title" :components="card.components">
                    <template v-slot:header>
                        <button type="submit" class="btn btn-primary btn-sm" style="float:right" data-bs-toggle="modal" :data-bs-target="'#'+modalAdd.id">Add Stash</button>
                    </template>

                    <template v-slot:body>
                        <stash-card-component v-for="stash, i in stashes" :key="i"
                            :stash="stash"
                        >
                        </stash-card-component>
                    </template>

                    <template v-slot:footer>
                        <button type="submit" class="btn btn-primary btn-sm" style="float:right" data-bs-toggle="modal" :data-bs-target="'#'+modalAdd.id">Add Stash</button>
                    </template>
                </card-component>

            </div>
        </div>

        <!-- start modal ADD_STASH_MODAL -->
        <modal-component :id="modalAdd.id" :title="modalAdd.title">
            <template v-slot:alerts>
                <alert-component :details="alert">
                </alert-component>
            </template>

            <template v-slot:content>
                <input-component classes="row mb-3" id="stashTitle" title="Title">
                    <input id="stashTitle" type="text" class="form-control" required autofocus v-model="stashTitle">
                </input-component>

                <input-component classes="row mb-3" id="stashDescription" title="Description">
                    <input id="stashDescription" type="text" class="form-control" required autofocus v-model="stashDescription">
                </input-component>

                <input-component classes="row mb-3" id="stashTopic" title="Topic">
                    <select id="">
                        <option value="" selected> Select a topic: </option>
                        <option :value="topic.id" v-for="topic, key in topics" :key="key">
                            {{ topic.id }} - {{ topic.title }}
                        </option>
                    </select>
                </input-component>
            </template>
            
            <template v-slot:footer>
                <button type="submit" class="btn btn-secondary" style="float:right" data-bs-dismiss="modal" @click="cleanNewStashData()">Cancel</button>
                <button type="submit" class="btn btn-primary" style="float:right" @click="addStash()">Add</button>
            </template>
        </modal-component>
        <!-- end modal ADD_STASH_MODAL -->

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
                baseUrl: 'http://alltreasures.herokuapp.com',
                stashes: [],
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
                alert: {
                    status: null,
                    object: {},
                    message: '',
                    errors: [],
                },
                mockStashes: [
                    {table_show: false, show: false, id: '1', user_id: '1', title: 'stash 01', topic: 'demo', description: 'collection of demo', artifacts: []},
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
            loadStashes() {
                this.stashes = this.mockStashes;

                // let url = this.baseUrl + '/stashes/all-stashes/' + this.userid;

                // let config = {
                //     headers: {
                //         'Accept': 'application/json',
                //     }
                // }

                // axios.get(url, config)
                //     .then(response => {
                //         console.log(response);
                //         this.stashes = response.data;
                //     })
                //     .catch(errors => {
                //         console.log(errors);
                //     });
            },
            loadTopics() {
                let url = this.baseUrl + '/topic/all-topics';

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
                        console.log (errors);
                    });
            },
            addStash() {
                let url = this.baseUrl + '/stash/create';

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
                        this.alert.status = 'success';
                        this.alert.object = response.data;
                        this.loadStashes();
                        console.log(response);
                    })
                    .catch(errors => {
                        this.alert.status = 'danger';
                        this.alert.message = errors.response.message;
                        this.alert.errors = errors.response.errors;
                        console.log(errors.response);
                    })
            },
            cleanNewStashData() {
                this.stashTitle = '',
                this.stashTopic = '',
                this.stashDescription = '',
                this.alert  = {
                    status: null,
                    object: {},
                    message: '',
                    errors: [],
                }
            },
        },
        mounted() {
            this.loadStashes();
            this.loadTopics();
        },
    }
</script>
