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
                <h3>{{ $t('register.title') }}</h3>
                <p class="mb-4 font-italic">{{ phrase }}</p>
              </div>
              <b-form @submit.prevent="register">
                <b-form-group :label="$t('auth.email')">
                  <b-form-input v-model="$v.form.email.$model" type="text" class="form-control form-control-lg"
                                id="email" :class="{ 'is-invalid': submitted && $v.form.email.$error }"
                  />
                  <b-form-invalid-feedback
                    id="input-confirmPassword-feedback">{{ $t('auth.emailError') }}
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

                <b-form-group :label="$t('register.confirmPass')">
                  <b-form-input v-model="$v.form.confirmPassword.$model" type="password"
                                class="form-control form-control-lg" id="input-confirmPassword"
                                :class="{ 'is-invalid': submitted && $v.form.confirmPassword.$error }"
                  />
                  <b-form-invalid-feedback
                    id="input-confirmPassword-feedback">{{ $t('register.confirmPassError') }}
                  </b-form-invalid-feedback>
                </b-form-group>
                <div class="d-flex mb-3 align-items-start">
                  <b-form-checkbox v-model="rememberMe">{{ $t('auth.rememberMe') }}</b-form-checkbox>
                  <span class="ml-auto"><a href="#" class="forgot-pass">{{ $t('auth.forgotPass') }}</a></span>
                </div>
                <b-button type="submit" class="btn btn-block btn-primary">{{ $t('register.title') }}</b-button>
              </b-form>
              <div class="text-center mt-2">
                <b-link class="font-weight-light" to="login">{{ $t('register.login') }}</b-link>
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
  name: "register",
  auth: 'guest',
  data() {
    return {
      phrase: ' ',
      submitted: false,
      rememberMe: 'false',
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
        confirmPassword: {required, sameAsPassword: sameAs('password')},
      }
    }
  },
  async fetch() {
    const response = await this.$axios.$get(process.env.PHRASE_URL)
    let number = Math.floor(Math.random() * response.length);
    this.phrase = response[number].text
  },
  methods: {
    async register() {
      this.submitted = true;
      this.$v.$touch();
      if (this.$v.$invalid) {
        return;
      }
      this.$toast.show('Registration...')
      await this.$axios.$post('api/register', this.form)
        .then((response) => {
          if (response['status'] === "Registration Complete!") {
            this.$toast.info('Registration Complete!')
            this.login()
          } else if (response['status'] === "Email already registered") {
            this.$toast.error('Email already registered')
          } else {
            this.$toast.error('Something went wrong')
          }
        })
    },
    async login() {
      if (!this.rememberMe) {
        await this.$auth.loginWith('local', {
          data: {
            email: this.form.email,
            password: this.form.password,
          },
        })
      } else {
        await this.$auth.loginWith('localRemember', {
          data: {
            email: this.form.email,
            password: this.form.password
          },
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

.btn-primary {
  background-color: rgb(108, 99, 255);
  border-color: rgb(108, 99, 255);
}


</style>
