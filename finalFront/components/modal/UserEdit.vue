<template>
  <b-modal size="lg" id="modal-user-edit" centered :title="$t('profileEdit.title') "
           @show="resetForm"
           @hidden="resetForm"
           @ok="handleOk">
    <b-form ref="form" class="row m-0 p">
      <div class="row col-12 mt-2 ">
        <span class="mb-0 col-3 ">{{ $t('profileEdit.field') }}</span>
        <span class="mb-0 col-3 ">{{ $t('profileEdit.previous') }}</span>
        <span class="mb-0  col-6 ">{{ $t('profileEdit.new') }}</span>
      </div>
      <div class="row col-12 mt-3">
        <label class="col-3 col-form-label ">{{ $t('profileEdit.firstName') }}</label>
        <div class="col-9 p-0">
          <b-form-group class="mb-0  col-12"
                        label-cols="4"
                        content-cols="8"
                        :label="authHandler('first_name')"
          >
            <b-input id="input-firstName" v-model="form.firstName"
            ></b-input>
          </b-form-group>
        </div>
      </div>
      <div class="row col-12 mt-3">
        <label class="col-3 col-form-label ">{{ $t('profileEdit.lastName') }}</label>
        <div class="col-9 p-0">
          <b-form-group class="mb-0  col-12"
                        label-cols="4"
                        content-cols="8"
                        :label="authHandler('last_name')"
          >
            <b-input id="input-lastName" v-model="form.lastName"
            ></b-input>
          </b-form-group>
        </div>
      </div>
      <div class="row col-12 mt-3">
        <label class="col-3 col-form-label ">{{ $t('profileEdit.taxRate') }}</label>
        <div class="col-9 p-0">
          <b-form-group class="mb-0  col-12"
                        label-cols="4"
                        content-cols="8"
                        :label="authHandler('tax_rate')"
          >
            <b-form-spinbutton id="sb-inline" v-model="form.taxRate" inline></b-form-spinbutton>
          </b-form-group>
        </div>
      </div>
      <div class="row col-12 mt-3">
        <label class="col-3 col-form-label ">{{ $t('profileEdit.forcePercentage') }}</label>
        <div class="col-9 p-0">
          <b-form-group class="mb-0  col-12"
                        label-cols="4"
                        content-cols="8"
                        :label="authHandler('force_exchange_percentage')"
          >
            <b-form-spinbutton id="sb-inline" v-model="form.forcePercentage" inline></b-form-spinbutton>
          </b-form-group>
        </div>
      </div>
      <div class="row col-12 mt-3">
        <label class="col-3 col-form-label ">{{ $t('profileEdit.exchangeFlag') }}</label>
        <div class="col-9 p-0">
          <b-form-group class="mb-0  col-12"
                        label-cols="4"
                        content-cols="8"
                        :label="authHandler('force_exchange_flag')"
          >
            <b-form-radio id="radioFalse" v-model="form.exchangeFlag" value="1">true</b-form-radio>
            <b-form-radio id="radioTrue" v-model="form.exchangeFlag" value="0">false</b-form-radio>
          </b-form-group>
        </div>
      </div>
      <div class="row col-12 mt-3">
        <label class="col-3 col-form-label ">{{ $t('profileEdit.notificationPeriod') }}</label>
        <div class="col-9 p-0">
          <b-form-group class="mb-0  col-12"
                        label-cols="4"
                        content-cols="8"
                        :label="authHandler('notification_period')"
          >
            <b-form-select id="input-notification"
                           v-model="form.notification"
                           :options="optionsNotification"
            >
            </b-form-select>
            <b-form-invalid-feedback
              id="input-action-feedback">{{ $t('actionAdd.selectError') }}
            </b-form-invalid-feedback>
          </b-form-group>
        </div>
      </div>
    </b-form>
    <template #modal-footer="{ ok, cancel, hide }">
      <!-- Emulate built in modal footer ok and cancel button actions -->
      <b-button variant="danger" @click="cancel()">
        {{ $t('actionAdd.cancel') }}
      </b-button>
      <b-button type="submit" variant="success" @click="ok()">
        {{ $t('actionAdd.ok') }}
      </b-button>
    </template>
  </b-modal>
</template>

<script>


export default {
  name: "ActionAdd",
  data() {
    return {
      optionsNotification: [
        {value: null, text: this.$t('profileEdit.optionsNotification.null')},
        {value: 'false', text: this.$t('profileEdit.optionsNotification.not')},
        {value: 'Every month', text: this.$t('profileEdit.optionsNotification.month')},
        {value: 'Every quarter', text: this.$t('profileEdit.optionsNotification.quarter')},
      ],
      form: {
        firstName: null,
        lastName: null,
        taxRate: null,
        forcePercentage: null,
        exchangeFlag: null,
        notification: null,
      },
    };
  },
  methods: {
    authHandler(field) {
      if (this.$auth.user[field] == null) {
        return '----'
      } else {
        if (field === 'force_exchange_flag') {
          return (this.$auth.user[field] === 1).toString()
        }
        return this.$auth.user[field].toString();
      }
    },

    handleOk(bvModalEvt) {
      bvModalEvt.preventDefault()
      this.handleSubmit()
    },

    resetForm() {
      this.form = this.$clearFields();
    },

    async handleSubmit() {
      const response = await this.$store.dispatch('user/EDIT_PROFILE', this.form)
      this.$nextTick(() => {
        this.$bvModal.hide('modal-user-edit')
      })
      if (response.status === "Update") {
        this.$toast.info('Update');
        await this.$auth.fetchUser()
      } else {
        if (response.status != null) {
          this.$toast.error(response.status);
        }
      }
    },
  },
}


</script>

<style scoped>

</style>
