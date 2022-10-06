<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component
                    title="Login"
                    :components="{
                        header: true,
                        body: true,
                        footer: false,
                    }"
                >
                    
                    <template v-slot:content>
                        <input-component
                            classes="row col-md-12"
                            title="Username"
                            :input="{
                                type: 'text',
                                id: 'username',
                                value: null,
                                placeholder: 'insert username',
                            }"
                        >
                        </input-component>
                        <br>
                        <input-component
                            classes="row col-md-12"
                            title="Super Big Password"
                            :input="{
                                type: 'password',
                                id: 'password',
                                value: null,
                                placeholder: 'insert password',
                            }"
                        >
                        </input-component>
                        <br>
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                        </div>
                    </template>
                
                </card-component>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [],
    }
</script>
