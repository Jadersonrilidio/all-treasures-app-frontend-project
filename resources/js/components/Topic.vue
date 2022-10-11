<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component :title="card.title" :components="card.components">
                    
                    <template v-slot:body>
                        <table-component
                            :columns="table_columns"
                            :buttons="table_buttons"
                            :items="topics"
                        >
                        </table-component>

                    </template>

                    <template v-slot:footer>
                        <button class="btn btn-primary btn-sm" style="float:right" data-bs-toggle="modal" :data-bs-target="'#'+modalAdd.id">Add Topic</button>
                    </template>

                </card-component>

            </div>
        </div>

        <!-- start modal ADD_TOPIC_MODAL -->
        <modal-component :id="modalAdd.id" :title="modalAdd.title">
            <template v-slot:alerts>
                <alert-component :details="alert">
                </alert-component>
            </template>

            <template v-slot:content>
                <input-component classes="row mb-3" id="topicTitle" title="Title">
                    <input id="topicTitle" type="text" class="form-control" required autofocus v-model="topicTitle">
                </input-component>
            </template>
            
            <template v-slot:footer>
                <button class="btn btn-secondary" style="float:right" data-bs-dismiss="modal" @click="cleanNewTopicData()">Cancel</button>
                <button class="btn btn-primary" style="float:right" @click="addTopic()">Add</button>
            </template>
        </modal-component>
        <!-- end modal ADD_TOPIC_MODAL -->

        <!-- start modal EDIT_TOPIC_MODAL -->
        <modal-component :id="modalEdit.id" :title="modalEdit.title">
            <template v-slot:alerts>
                <alert-component :details="alert">
                </alert-component>
            </template>

            <template v-slot:content>
                <input-component classes="row mb-3" id="topicTitle" title="Title">
                    <input id="topicTitle" type="text" class="form-control" required autofocus v-model="$store.state.item.title" v-if="$store.state.item.title">
                </input-component>
            </template>
            
            <template v-slot:footer>
                <button class="btn btn-secondary" style="float:right" data-bs-dismiss="modal" @click="cleanNewTopicData()">Cancel</button>
                <button class="btn btn-success" style="float:right" @click="updateTopic()">Update</button>
            </template>
        </modal-component>
        <!-- end modal EDIT_TOPIC_MODAL -->

        <!-- start modal DELETE_TOPIC_MODAL -->
        <modal-component :id="modalDelete.id" :title="modalDelete.title">
            <template v-slot:alerts>
                <alert-component :details="alert">
                </alert-component>
            </template>

            <template v-slot:content>
                <input-component classes="row mb-3" title="Title" v-if="!alert.status">
                    <input type="text" class="form-control" disabled :value="$store.state.item.title" v-if="$store.state.item.title">
                </input-component>
            </template>
            
            <template v-slot:footer>
                <button class="btn btn-secondary" style="float:right" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-danger" style="float:right" @click="deleteTopic()" v-if="!alert.status">Delete</button>
            </template>
        </modal-component>
        <!-- end modal DELETE_TOPIC_MODAL -->

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
                topics: [],
                topicTitle: '',
                card: {
                    title: 'Topics list',
                    components: {
                        header: true,
                        body: true,
                        footer: true
                    }
                },
                alert: {
                    status: null,
                    object: {},
                    message: '',
                    errors: [],
                },
                modalAdd: {
                    id: 'addTopicModal',
                    title: 'Add New Topic'
                },
                modalEdit: {
                    id: 'editTopicModal',
                    title: 'Edit Topic'
                },
                modalDelete: {
                    id: 'deleteTopicModal',
                    title: 'Delete Topic'
                },
                table_columns: {
                    id: 'ID',
                    title: 'Topic'
                },
                table_buttons: {
                    edit: {
                        title: 'Edit',
                        class: 'success',
                        target: '#editTopicModal'
                    },
                    delete: {
                        title: 'Delete',
                        class: 'danger',
                        target: '#deleteTopicModal'
                    }
                },
            }
        },
        methods: {
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
                        console.log('%c Load topics Success: check it out!', 'background: #41AF41', `Route: ${url}`, response);
                    })
                    .catch(errors => {
                        console.log('%c Load topics Error: nothing happened', 'background: #FEC302', `Route: ${url}`, errors.response);
                    });
            },
            addTopic() {
                let url = this.baseUrl;

                let formData = new FormData();
                formData.append('title', this.topicTitle);

                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'multipart/form-data'
                    }
                }

                axios.post(url, formData, config)
                    .then(response => {
                        this.alert.status = 'success';
                        this.alert.object = response.data;
                        this.loadTopics();
                        this.cleanNewTopicData();
                        console.log('%c Add topic Success: check it out!', 'background: #41AF41', `Route: ${url}`, response);
                    })
                    .catch(errors => {
                        this.alert.status = 'danger';
                        this.alert.message = errors.response.message;
                        this.alert.errors = errors.response.errors;
                        console.log('%c Add topic Error: nothing happened', 'background: #FEC302', `Route: ${url}`, errors.response);
                    })
            },
            updateTopic() {
                let url = this.baseUrl + '/topic/' + this.$store.state.item.id;

                let formData = new FormData();
                formData.append('title', this.$store.state.item.title);

                let config = {
                    headers: {
                        '_method': 'PUT',
                        'Accept': 'application/json',
                        'Content-Type': 'multipart/form-data'
                    }
                }

                axios.post(url, formData, config)
                    .then(response => {
                        this.alert.status = 'success';
                        this.alert.object = response.data;
                        this.loadTopics();
                        console.log('%c Update topic Success: check it out!', 'background: #41AF41', `Route: ${url}`, response);
                    })
                    .catch(errors => {
                        this.alert.status = 'danger';
                        this.alert.message = errors.response.message;
                        this.alert.errors = errors.response.errors;
                        console.log('%c Update topic Error: nothing happened', 'background: #FEC302', `Route: ${url}`, errors.response);
                    })
            },
            deleteTopic() {
                let url = this.baseUrl + '/topic/' + this.$store.state.item.id;

                let config = {
                    headers: {
                        'Accept': 'application/json'
                    }
                }

                axios.delete(url, config)
                    .then(response => {
                        this.alert.status = 'success';
                        // this.alert.object = response.data.content;
                        this.loadTopics();
                        console.log('%c Delete topic Success: check it out!', 'background: #41AF41', `Route: ${url}`, response);
                    })
                    .catch(errors => {
                        console.log('%c Delete topic Error: nothing happened', 'background: #FEC302', `Route: ${url}`, errors.response);
                    });
            },
            cleanNewTopicData() {
                this.topicTitle = '';
                this.alert = {
                    status: null,
                    object: {},
                    message: '',
                    errors: [],
                }
            }
        },
        mounted() {
            this.loadTopics();
        },
    }
</script>
