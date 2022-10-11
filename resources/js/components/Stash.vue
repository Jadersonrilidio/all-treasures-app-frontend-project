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
                            :columns="stash_card_columns"
                            :buttons="stash_card_buttons"
                            :table-columns="table_columns"
                            :table-buttons="table_buttons"
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
                    <select id="" v-model="stashTopic">
                        <option value="" selected> -- Select a topic: -- </option>
                        <option :value="topic.id" v-for="topic, key in topics" :key="key">
                            {{ topic.title }}
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

        <!-- start modal EDIT_STASH_MODAL -->
        <modal-component :id="modalEdit.id" :title="modalEdit.title">
            <template v-slot:alerts>
                <alert-component :details="alert">
                </alert-component>
            </template>

            <template v-slot:content>
                <input-component classes="row mb-3" id="stashTitle" title="Title">
                    <input id="stashTitle" type="text" class="form-control" required autofocus v-model="$store.state.item.title" v-if="$store.state.item.title">
                </input-component>

                <input-component classes="row mb-3" id="stashDescription" title="Description">
                    <input id="stashDescription" type="text" class="form-control" required autofocus v-model="$store.state.item.description" v-if="$store.state.item.description">
                </input-component>

                <input-component classes="row mb-3" id="stashTopic" title="Topic">
                    <select id="" v-model="$store.state.item.topic" v-if="$store.state.item.topic">
                        <option value=""> -- Select a topic: -- </option>
                        <option :value="topic.id" v-for="topic, key in topics" :key="key">
                            {{ topic.title }}
                        </option>
                    </select>
                </input-component>
            </template>
            
            <template v-slot:footer>
                <button class="btn btn-secondary" style="float:right" data-bs-dismiss="modal" @click="cleanAlerts()">Cancel</button>
                <button class="btn btn-success" style="float:right" @click="updateStash()">Update</button>
            </template>
        </modal-component>
        <!-- end modal EDIT_STASH_MODAL -->

        <!-- start modal DELETE_STASH_MODAL -->
        <modal-component :id="modalDelete.id" :title="modalDelete.title">
            <template v-slot:alerts>
                <alert-component :details="alert">
                </alert-component>
            </template>

            <template v-slot:content>
                <input-component classes="row mb-3" title="Title" v-if="!alert.status">
                    <input type="text" class="form-control" disabled :value="$store.state.item.title" v-if="$store.state.item.title">
                </input-component>

                <div style="text-align:center">
                    <span>
                        <b>ATTENTION!!!</b>
                        All contained artifacts will be deleted as well.
                    </span>
                </div>
            </template>
            
            <template v-slot:footer>
                <span>Are you sure to delete stash? &emsp;&emsp;&emsp;</span>
                <button class="btn btn-secondary" style="float:right" data-bs-dismiss="modal" @click="cleanAlerts()">Close</button>
                <button class="btn btn-danger" style="float:right" @click="deleteStash()" v-if="!alert.status">Delete</button>
            </template>
        </modal-component>
        <!-- end modal DELETE_STASH_MODAL -->

        <!-- start modal EDIT_ARTIFACT_MODAL -->
        <modal-component id="editArtifactModal" title="Edit Artifact">
            <template v-slot:alerts>
                <alert-component :details="alert">
                </alert-component>
            </template>
    
            <template v-slot:content>
                <input-component classes="row mb-3" title="Title">
                    <input type="text" class="form-control" required autofocus v-model="$store.state.item.title" v-if="$store.state.item.title">
                </input-component>
    
                <input-component classes="row mb-3" title="Tags">
                    <input type="text" class="form-control" required autofocus v-model="$store.state.item.tags" v-if="$store.state.item.tags">
                </input-component>
            </template>
            
            <template v-slot:footer>
                <button type="submit" class="btn btn-secondary" style="float:right" data-bs-dismiss="modal" @click="cleanAlerts()">Cancel</button>
                <button type="submit" class="btn btn-success" style="float:right" @click="updateArtifact()">Update</button>
            </template>
        </modal-component>
        <!-- end modal EDIT_ARTIFACT_MODAL -->

        <!-- start modal DELETE_ARTIFACT_MODAL -->
        <modal-component id="deleteArtifactModal" title="Delete Artifact">
            <template v-slot:alerts>
                <alert-component :details="alert">
                </alert-component>
            </template>
    
            <template v-slot:content>
                <input-component classes="row mb-3" title="Title" v-if="!alert.status">
                    <input type="text" class="form-control" disabled :value="$store.state.item.title" v-if="$store.state.item.title">
                </input-component>
    
                <input-component classes="row mb-3" title="Tags" v-if="!alert.status">
                    <input type="text" class="form-control" disabled :value="$store.state.item.tags" v-if="$store.state.item.tags">
                </input-component>
            </template>
            
            <template v-slot:footer>
                <span>Are you sure to delete artifact? &emsp;&emsp;&emsp;</span>
                <button type="submit" class="btn btn-secondary" style="float:right" data-bs-dismiss="modal" @click="cleanAlerts()">Close</button>
                <button type="submit" class="btn btn-danger" style="float:right" @click="deleteArtifact()" v-if="!alert.status">Delete</button>
            </template>
        </modal-component>
        <!-- end modal DELETE_ARTIFACT_MODAL -->

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
                modalEdit: {
                    id: 'editStashModal',
                    title: 'Edit Stash'
                },
                modalDelete: {
                    id: 'deleteStashModal',
                    title: 'Delete Stash'
                },
                stash_card_columns: {
                    id: {
                        title: 'ID'
                    },
                    user_id: {
                        title: 'User ID'
                    },
                    title: {
                        title: 'Stash'
                    },
                    topic: {
                        title: 'Related Topic'
                    },
                    description: {
                        title: 'Description'
                    }
                },
                stash_card_buttons: {
                    // view: {
                    //     type: 'link',
                    //     title: 'View',
                    //     class: 'primary',
                    //     target: ''
                    // },
                    edit: {
                        type: 'modal',
                        title: 'Edit',
                        class: 'success',
                        target: '#editStashModal'
                    },
                    delete: {
                        type: 'modal',
                        title: 'Delete',
                        class: 'danger',
                        target: '#deleteStashModal'
                    }
                },
                table_columns: {
                    id: 'ID',
                    title: 'Artifact',
                    stash_id: 'Stash ID',
                    tags: 'Tags',
                },
                table_buttons: {
                    edit: {
                        type: 'modal',
                        title: 'Edit',
                        class: 'success',
                        target: '#editArtifactModal'
                    },
                    delete: {
                        type: 'modal',
                        title: 'Delete',
                        class: 'danger',
                        target: '#deleteArtifactModal'
                    }
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
                ],
                mockTopics: [
                    {id: '1', title: 'topic model 01'},
                    {id: '2', title: 'topic model 02'},
                    {id: '3', title: 'topic model 03'},
                    {id: '4', title: 'topic model 04'},
                    {id: '5', title: 'topic model 05'},
                    {id: '6', title: 'topic model 06'},
                ]
            }
        },
        methods: {
            loadStashes() {
                let url = this.baseUrl + '/stashes/all-stashes/' + this.userid;

                let config = {
                    headers: {
                        'Accept': 'application/json',
                    }
                }

                axios.get(url, config)
                    .then(response => {
                        this.stashes = response.data.content;
                        console.log('%c Load stashes Success: \n Route: ', 'background: #41AF41', url, response);
                    })
                    .catch(errors => {
                        this.stashes = this.mockStashes;
                        console.log('%c Load stashes Error: loading mock stashes instead \n Route: ', 'background: #FEC302', url, errors.response);
                    });
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
                        this.topics = response.data.content;
                        console.log('%c Load topics Success: check it out! \n Route: ', 'background: #41AF41', url, response);
                    })
                    .catch(errors => {
                        this.topics = this.mockTopics;
                        console.log('%c Load Topics Error: loading mock topics instead \n Route: ', 'background: #FEC302', url, errors.response);
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
                        'Content-Type': 'multipart/form-date',
                        'Accept': 'application/json'
                    }
                };

                axios.post(url, formData, config)
                    .then(response => {
                        this.alert.status = 'success';
                        this.alert.object = response.data;
                        this.loadStashes();
                        console.log('%c Add stash Success: check it out! \n Route: ', 'background: #41AF41', url, response);
                    })
                    .catch(errors => {
                        this.alert.status = 'danger';
                        this.alert.message = errors.response.message;
                        this.alert.errors = errors.response.errors;
                        console.log('%c Add stash Error: nothing happened \n Route: ', 'background: #FEC302', url, errors.response);
                    })
            },
            updateStash() {
                let url = this.baseUrl + '/stash/' + this.$store.state.item.id;

                let formData = new FormData();
                formData.append('user_id', this.userid);
                formData.append('title', this.$store.state.item.title);
                formData.append('topic', this.$store.state.item.topic);
                formData.append('description', this.$store.state.item.description);

                let config = {
                    headers: {
                        '_method': 'PUT',
                        'Accept': 'application/json',
                        'Content-Type': 'multipart/form-date'
                    }
                };

                axios.post(url, formData, config)
                    .then(response => {
                        this.alert.status = 'success';
                        this.alert.object = response.data;
                        this.loadStashes();
                        console.log('%c Update stash Success: check it out! \n Route: ', 'background: #41AF41', url, response);
                    })
                    .catch(errors => {
                        this.alert.status = 'danger';
                        this.alert.message = errors.response.message;
                        this.alert.errors = errors.response.errors;
                        console.log('%c Update stash Error: nothing happened \n Route: ', 'background: #FEC302', url, errors.response);
                    })
            },
            deleteStash() {
                let url = this.baseUrl + '/stash/' + this.$store.state.item.id;

                let config = {
                    headers: {
                        'Accept': 'application/json'
                    }
                };

                axios.delete(url, config)
                    .then(response => {
                        this.alert.status = 'success';
                        this.loadStashes();
                        console.log('%c Delete stash Success: check it out! \n Route: ', 'background: #41AF41', url, response);
                    })
                    .catch(errors => {
                        this.alert.status = 'danger';
                        this.alert.message = errors.response.message;
                        this.alert.errors = errors.response.errors;
                        console.log('%c Delete stash Error: nothing happened \n Route: ', 'background: #FEC302', url, errors.response);
                    })
            },
            updateArtifact() {
                let url = this.baseUrl + '/artifact/' + $store.state.item.id;
                
                let formData = new FormData();
                formData.append('title', this.$store.state.item.title);
                formData.append('stashId', this.$store.state.item.stashId);
                formData.append('tags', this.storeTagsToArray());

                let config = {
                    headers: {
                        '_method': 'PUT',
                        'Accept': 'application/json',
                        'Content-Type': 'multipart/form-data'
                    }
                }

                axios.post(url, formData, config)
                    .then(response => {
                        this.loadStashes();
                        this.alert.status = 'success';
                        this.alert.object = response.data;
                        console.log('%c Update artifact Success: check it out! \n Route: ', 'background: #41AF41', url, response);
                    })
                    .catch(errors => {
                        this.alert.status = 'danger';
                        this.alert.message = errors.response.message;
                        this.alert.errors = errors.response.errors;
                        console.log('%c Update artifact Error: nothing happened \n Route: ', 'background: #FEC302', url, errors.response);
                    })
            },
            deleteArtifact() {
                let url = this.baseUrl + '/artifact/' + this.$store.state.item.id;

                let config = {
                    headers: {
                        'Accept': 'application/json'
                    }
                };

                axios.delete(url, config)
                    .then(response => {
                        this.alert.status = 'success';
                        this.loadStashes();
                        console.log('%c Delete artifact Success: check it out! \n Route: ', 'background: #41AF41', url, response);
                    })
                    .catch(errors => {
                        this.alert.status = 'danger';
                        this.alert.message = errors.response.message;
                        this.alert.errors = errors.response.errors;
                        console.log('%c Delete artifact Error: nothing happened \n Route: ', 'background: #FEC302', url, errors.response);
                    })
            },
            cleanNewStashData() {
                this.stashTitle = '',
                this.stashTopic = '',
                this.stashDescription = '',
                this.cleanAlerts()
            },
            cleanAlerts() {
                this.alert  = {
                    status: null,
                    object: {},
                    message: '',
                    errors: [],
                }
            },
            storeTagsToArray() {
                return this.$store.state.item.tags.split(', ').split(',');
            }
        },
        mounted() {
            this.loadStashes();
            this.loadTopics();
        },
    }
</script>
