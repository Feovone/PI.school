<template>
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="~/assets/images/loginLogo.svg" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
                <h3>{{ $t('login.title') }}</h3>
                <p class="mb-4 font-italic">{{ phrase }}</p>
              </div>
              <b-form @submit.prevent="login">
                <b-form-group :label="$t('auth.email')">
                  <b-form-input v-model="$v.form.email.$model" type="text" class="form-control form-control-lg"
                                id="email" :class="{ 'is-invalid': submitted && $v.form.email.$error }"
                  />

                  <b-form-invalid-feedback
                    id="input-email-feedback">{{ $t('auth.emailError') }}
                  </b-form-invalid-feedback>
                </b-form-group>

                <b-form-group :label="$t('auth.pass')">
                  <b-form-input v-model="$v.form.password.$model" type="password" class="form-control form-control-lg"
                                id="password" :class="{ 'is-invalid': submitted && $v.form.password.$error }"
                  />
                  <b-form-invalid-feedback
                    id="input-password-feedback">{{ $t('auth.passError') }}
                  </b-form-invalid-feedback>
                </b-form-group>

                <div class="d-flex mb-3 align-items-start">
                  <b-form-checkbox v-model="rememberMe">{{ $t('auth.rememberMe') }}</b-form-checkbox>
                  <span class="ml-auto"><a href="#" class="forgot-pass">{{ $t('auth.forgotPass') }}</a></span>
                </div>
                <b-button type="submit" class="btn btn-block btn-primary">{{ $t('login.title') }}</b-button>
              </b-form>
              <div class="text-center mt-2">
                <b-link class="font-weight-light" to="register">{{ $t('login.register') }}</b-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {numeric, required, email, minLength, sameAs} from "vuelidate/lib/validators";
import {validationMixin} from "vuelidate";

export default {
  name: "login",
  auth: 'guest',
  data() {
    return {
      rememberMe: false,
      phrase: ' ',
      title: 'Sign In',
      action: 'Registration',
      submitted: false,
      form: {
        email: null,
        password: null,
        confirmPassword: null,
      }
    }
  },
  validations() {
    return {
      form: {
        email: {required, email},
        password: {required, minLength: minLength(6)},
        confirmPassword: {}
      }
    }
  },
  async fetch() {
    const response = await this.$axios.$get(process.env.PHRASE_URL)
    let number = Math.floor(Math.random() * response.length);
    this.phrase = response[number].text
  },
  methods: {
    async login() {
      this.submitted = true;
      this.$v.$touch();
      if (this.$v.$invalid) {
        return;
      }
      if (this.rememberMe === false) {

        this.$toast.show('Logging in...')
        await this.$auth.loginWith('local', {
          data: {
            email: this.form.email,
            password: this.form.password,
          },
        }).then((response) => {
          if (response.data['status'] === "Incorrect credentials") {
            this.$toast.error('Incorrect credentials')
          } else {
            this.$toast.info('Correct credentials')
          }
        })
      } else {
        await this.$auth.loginWith('localRemember', {
          data: {
            email: this.form.email,
            password: this.form.password
          },
        }).then((response) => {
          if (response.data['status'] === "Incorrect credentials") {
            this.$toast.error('Incorrect credentials')
          } else {
            this.$toast.info('Correct credentials')
          }
        })
      }
    },


  }
}
</script>

<style scoped>
.content {
  padding: 10%;
}

</style>
