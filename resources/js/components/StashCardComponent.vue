<template>
    <div class="card mt-4 mb-4">

        <div class="card-header" @click.prevent="toggleCardBody(stash)" style="cursor:pointer">
            
            <nav class="navbar">
                {{ stash.title }}

                <div class="navbar-nav" style="display:inline;float:right">
                    <button v-for="button, i in buttons" :key="i"
                        style="margin-left:10px"
                        class="btn btn-sm"
                        :class="'btn-outline-'+button.class"
                        type="submit"
                        data-bs-toggle="modal"
                        :data-bs-target="button.target"
                        @click="storeItem(stash)"
                    >
                        {{ button.title }}
                    </button>
                </div>
            </nav>

        </div>

        <div class="card-body" v-if="stash.show">

            <ul style="list-style:none">
                <li v-for="column, attr in columns" :key="attr">
                    <b>{{ column.title }}: </b>
                    {{ stash[attr] ?? 'not defined' }}
                </li>
                
                <li>
                    <b>Artifacts: </b>
                    {{ numberOfArtifacts ?? 'not defined' }}
                </li>
            </ul>

            <div v-if="numberOfArtifacts > 0">
                <div v-if="stash.table_show">
                    <div style="text-align:center; padding-bottom:10px">
                        <button class="btn" style="background-color:lightgray; border:none; color:gray" @click.prevent="toggleArtifactsTable()">
                            &uarr;
                            <br>
                            Hide
                        </button>
                    </div>

                    <table-component
                        :columns="table_columns"
                        :buttons="table_buttons"
                        :items="artifacts"
                    >
                    </table-component>
                </div>

                <div v-else>
                    <div style="text-align:center; padding-bottom:10px">
                        <button class="btn" style="background-color:lightgray; border:none; color:gray" @click.prevent="toggleArtifactsTable()">
                            Show
                            <br>
                            &darr;
                        </button>
                    </div>
                </div>
            </div>

            <div v-else>
                <div style="text-align:center; padding-bottom:10px">
                    <button class="btn" style="background-color:lightgray; border:none; color:gray" disabled>
                        No artifacts to show
                    </button>
                </div>
            </div>

        </div>

        <div class="card-footer" v-if="stash.show">
            <!-- Button trigger modal // ADD_ARTIFACT_MODAL -->
            <button class="btn btn-sm btn-primary" style="float:right" data-bs-toggle="modal" :data-bs-target="'#'+modalAdd.id">
                Add New Artifact
            </button>
        </div>

    <!-- start modal ADD_ARTIFACT_MODAL -->
    <modal-component :id="modalAdd.id" :title="modalAdd.title">
        <template v-slot:alerts>
            <alert-component :details="alert">
            </alert-component>
        </template>

        <template v-slot:content>

            <input-component classes="row mb-3" id="artifactTitle" title="Title">
                <input id="artifactTitle" type="text" class="form-control" required autofocus v-model="artifactTitle">
            </input-component>

            <input-component classes="row mb-3" id="artifactTags" title="Tags">
                <input id="artifactTags" type="text" class="form-control" required autofocus v-model="artifactTags">
            </input-component>

        </template>
        
        <template v-slot:footer>
            <button type="submit" class="btn btn-secondary" style="float:right" data-bs-dismiss="modal" @click="cleanNewArtifactData()">Cancel</button>
            <button type="submit" class="btn btn-primary" style="float:right" @click="addArtifact()">Add</button>
        </template>
    </modal-component>

    </div>
</template>

<script>
    export default {
        props: [
            'columns',
            'buttons',
            'stash'
        ],
        data() {
            return {
                baseUrl: 'http://alltreasures.herokuapp.com',
                artifacts: [],
                table_columns: {
                    id: 'ID',
                    title: 'Artifact',
                    stash_id: 'Stash ID',
                    tags: 'Tags',
                },
                table_buttons: {
                    edit: {
                        title: 'Edit',
                        class: 'success',
                    },
                    delete: {
                        title: 'Delete',
                        class: 'danger',
                    }
                },
                modalAdd: {
                    id: 'addArtifactModal_' + this.stash.id,
                    title: 'Add New Artifact to stash ' + this.stash.title
                },
                artifactTitle: '',
                artifactStashId: this.stash.id,
                artifactTags: '',
                alert: {
                    status: null,
                    object: {},
                    message: '',
                    errors: [],
                }
            }
        },
        methods: {
            loadStashArtifacts() {
                let url = this.baseUrl + '/artifact/all-artifacts/stash_id=' + this.stash.id;

                let config = {
                    headers: {
                        'Accept': 'application/json'
                    }
                };

                axios.get(url, config)
                    .then(response => {
                        this.artifacts = response.data.content;
                        // this.artifacts = this.stash.artifacts;
                        console.log('%c Load stash ' + this.stash.title + ' artifacts Success: check it out! \n Route: ', 'background: #41AF41', url, response);
                    })
                    .catch(errors => {
                        this.artifacts = this.stash.artifacts;
                        console.log('%c Load stash ' + this.stash.title + ' artifacts Error: nothing happened \n Route: ', 'background: #FEC302', url, errors.response);
                    })
            },
            addArtifact() {
                let url = this.baseUrl + '/artifact/create';

                let formData = new FormData();
                formData.append('title', this.artifactTitle);
                formData.append('stashId', this.artifactStashId);
                formData.append('tags', this.tagsToArray);

                let config = {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                }

                axios.post(url, formData, config)
                    .then(response => {
                        this.alert.status = 'success';
                        this.alert.object = response.data;
                        this.loadStashArtifacts();
                        this.cleanNewArtifactData();
                        console.log('%c Add artifact Success: check it out! \n Route: ', 'background: #41AF41', url, response);
                    })
                    .catch(errors => {
                        console.log('%c Add artifact Error: nothing happened \n Route: ', 'background: #FEC302', url, errors.response);
                    })
            },
            cleanNewArtifactData() {
                this.artifactTitle = '',
                this.artifactStashId = this.stash.id,
                this.artifactTags = '',
                this.cleanAlert()
            },
            cleanAlert() {
                this.alert = {
                    status: null,
                    object: {},
                    message: '',
                    errors: [],
                }
            },
            setStashAttributes() {
                this.stash['show'] = false;
                this.stash['table_show'] = false;
            },
            toggleCardBody() {
                this.stash.show = this.stash.show ? false : true;
            },
            toggleArtifactsTable() {
                this.stash.table_show = this.stash.table_show ? false : true;
            },
            storeItem(stash) {
                this.$store.state.item = stash;
            }
        },
        computed: {
            numberOfArtifacts() {
                return this.artifacts ? this.artifacts.length : 0;
            },
            tagsToArray() {
                return this.artifactTags.split(', ');
            }
        },
        mounted() {
            this.loadStashArtifacts();
            this.setStashAttributes();
        }
    }
</script>
