<template>
    <div class="card mt-4 mb-4">

        <div class="card-header" @click.prevent="toggleCardBody(stash)" style="cursor:pointer">
            
            <nav class="navbar">
                {{ stash.title }}

                <div class="navbar-nav" style="display:inline;float:right">
                    <button v-for="button, i in buttons" :key="i"
                        class="btn btn-sm"
                        style="margin-left:10px"
                        type="submit"
                        :href="button.baseLink"
                        data-toggle="modal"
                        :class="'btn-outline-'+button.class"
                        :data-target="button.target"
                    >
                        {{ button.title }}
                    </button>
                </div>
            </nav>

        </div>

        <div class="card-body" v-if="stash.show">

            <ul style="list-style:none">
                <!-- <li v-for="column, attr in columns" :key="attr">
                    <b>{{ column.title }}: </b>
                    {{ stash.attr ?? 'not defined' }}
                </li> -->
                
                <li><b>ID: </b> {{ stash.id ?? 'not defined' }} </li>
                <li><b>User ID: </b> {{ stash.user_id ?? 'not defined' }} </li>
                <li><b>Title: </b> {{ stash.title ?? 'not defined' }} </li>
                <li><b>Related Topic: </b> {{ stash.topic ?? 'not defined' }} </li>
                <li><b>Description: </b> {{ stash.description ?? 'not defined' }} </li>
                <li><b>Artifacts: </b> {{ numberOfArtifacts(stash.artifacts) ?? 'not defined' }} </li>
            </ul>

            <div v-if="stash.table_show">
                <div class="">
                    <button class="btn btn-sm btn-secondary" @click.prevent="toggleArtifactsTable(stash)">
                        Hide Artifacts
                    </button>
                </div>

                <table-component
                    :columns="table_columns"
                    :buttons="table_buttons"
                    :items="stash.artifacts"
                >
    
                    <!-- <template v-slot:rows>
                        <tr v-for="artifact, key in stash.artifacts" :key="key">
                            <td v-for="value, attr in artifact" :key="attr">
                                {{ value }}
                            </td>
                        </tr>
                    </template> -->
    
                </table-component>

            </div>

            <div v-else>
                <div class="">
                    <button class="btn btn-sm btn-secondary" @click.prevent="toggleArtifactsTable(stash)">
                        Show Artifacts
                    </button>
                </div>
            </div>

        </div>

        <div class="card-footer" v-if="stash.show">
            <!-- Button trigger modal // ADD_ARTIFACT_MODAL -->
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addArtifactModal">
                Add New Artifact
            </button>
        </div>
    
    </div>
</template>

<script>
    export default {
        props: [
            'stash'
        ],
        data() {
            return {
                buttons: {
                    view: {
                        title: 'View',
                        class: 'primary',
                        target: '',
                        baseLink: 'http://localhost:8000/stash',
                    },
                    edit: {
                        title: 'Edit',
                        class: 'success',
                        target: '#editStashModal',
                        baseLink: '#'
                    },
                    delete: {
                        title: 'Delete',
                        class: 'danger',
                        target: '#deleteStashModal',
                        baseLink: '#'
                    }
                },
                columns: {
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
                    },
                    artifacts: {
                        title: 'Artifacts'
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
                        title: 'Edit',
                        class: 'success',
                    },
                    delete: {
                        title: 'Delete',
                        class: 'danger',
                    }
                }
            }
        },
        methods: {
            numberOfArtifacts(artifacts) {
                return artifacts ? artifacts.length : 0;
            },
            toggleCardBody(stash) {
                stash.show = stash.show ? false : true;
            },
            toggleArtifactsTable(stash) {
                stash.table_show = stash.table_show ? false : true;
            }
        }
    }
</script>
