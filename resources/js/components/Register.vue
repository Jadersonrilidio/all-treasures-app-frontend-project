<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component :title="card.title" :components="card.components">

                    <template v-slot:body>

                        <form method="POST" :action="routeLogin" @submit.prevent="register($event)">

                            <input type="hidden" name="_token" :value="csrf_token">

                            <input-component classes="row mb-3" id="username" title="Username">
                                <input id="username" type="text" name="username" class="form-control" required autofocus v-model="username">
                            </input-component>

                            <input-component classes="row mb-3" id="password" title="Password">
                                <input id="password" type="password" name="password" class="form-control" required autofocus v-model="password">
                            </input-component>

                            <input-component classes="row mb-3" id="password_confirm" title="Confirm Password">
                                <input id="password_confirm" type="password" name="password_confirm" class="form-control" required autofocus v-model="password_confirm">
                            </input-component>
                            
                                <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
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
            'routeLogin'
        ],
        data() {
            return {
                baseUrl: 'https://alltreasures.herokuapp.com/user/signup',
                username: '',
                password: '',
                password_confirm: '',
                card: {
                    title: 'Register',
                    components: {
                        header: true,
                        body: true,
                        footer: false
                    }
                }
            }
        },
        methods: {
            register(event) {
                if (this.password != this.password_confirm) return;

                let formData = new FormData();
                formData.append('username', this.username);
                formData.append('password', this.password);
                formData.append('password_confirm', this.password_confirm);

                let config = {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                };

                axios.post(this.baseUrl, formData, config)
                    .then(response => {
                        console.log(response);
                        event.target.submit();
                    })
                    .catch(errors => {
                        console.log(errors.response);
                    });
            }
        }
    }
</script>
