<template>
    <div>
        <b-form @submit.prevent="onSubmit" class="form-signin">
            <b-form-group
                id="input-group-email"
                label="Email address:"
                label-for="email"
            >
                <b-form-input
                    id="email"
                    v-model="form.email"
                    type="email"
                    placeholder="Enter email"
                    :state="form.errors.has('email') ? false : null"
                ></b-form-input>
                <b-form-invalid-feedback :state="form.errors.has('email') ? false : null">
                    {{ form.errors.get('email') }}
                </b-form-invalid-feedback>
            </b-form-group>

            <b-form-group id="input-group-password" label="Password:" label-for="password" class="mb-4">
                <b-form-input
                    id="password"
                    type="password"
                    v-model="form.password"
                    placeholder="Enter your password"
                    :state="form.errors.has('password') ? false : null"
                ></b-form-input>
                <b-form-invalid-feedback :state="form.errors.has('password') ? false : null">
                    {{ form.errors.get('password') }}
                </b-form-invalid-feedback>
            </b-form-group>
            <b-button type="submit" variant="primary">Login</b-button>
        </b-form>
    </div>
</template>

<script>
import Form from 'vform';

export default {
    name: "Login",
    data() {
        return {
            form: new Form({
                email: '',
                password: ''
            }),
        }
    },
    methods: {
        async onSubmit() {
            const vue = this;
            await this.form.post('/api/v1/login').then(function (response) {
                const {data} = response
                vue.$store.dispatch('auth/saveToken', {
                    token: data.token,
                })
                vue.$router.push({ name: 'tasks' })
            });
        }
    }
}
</script>

<style scoped lang="scss">
body {
    display: -ms-flexbox;
    display: -webkit-box;
    display: flex;
    -ms-flex-align: center;
    -ms-flex-pack: center;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
    padding-top: 40px;
    padding-bottom: 40px;
    background-color: #f5f5f5;
}

.form-signin {
    width: 100%;
    max-width: 330px;
    padding: 15px;
    margin: 0 auto;

    .checkbox {
        font-weight: 400;
    }

    .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;

        &:focus {
            z-index: 2;
        }

        input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
    }
}
</style>
