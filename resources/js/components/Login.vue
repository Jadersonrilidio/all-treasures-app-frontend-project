<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <card-component :title="card.title" :components="card.components">

                    <template v-slot:body>

                        <form method="POST" action="" @submit.prevent="login($event)">

                            <input type="hidden" name="_token" :value="csrf_token">

                            <input id="userid" type="hidden" name="userid" :value="userid">

                            <input-component classes="row mb-3" id="username" title="Username">
                                <input id="username" type="text" name="username" class="form-control" required autocomplete="name" autofocus v-model="username">
                            </input-component>
                        
                            <input-component classes="row mb-3" id="password" title="Password">
                                <input id="password" type="password" name="password" class="form-control" required autofocus v-model="password">
                            </input-component>
                    
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>
                                </div>
                            </div>

                        </form>

                    </template>

                </card-component>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'csrf_token',
        ],
        data() {
            return {
                baseUrl: 'https://alltreasures.herokuapp.com',
                userid: '',
                username: '',
                password: '',
                card: {
                    title: 'Login',
                    components: {
                        header: true,
                        body: true,
                        footer: false
                    }
                },
            }
        },
        methods: {
            login(event) {
                let url = this.baseUrl + '/user/' + this.username;

                let config = {
                    headers: {
                        'Accept': 'application/json',
                    }
                }

                axios.get(url, config)
                    .then(response => {
                        userid.value = response.data.userId;
                        event.target.submit();
                    })
                    .catch(errors => {
                        console.log(errors.response);
                    });
            }

        }
    }
</script>
