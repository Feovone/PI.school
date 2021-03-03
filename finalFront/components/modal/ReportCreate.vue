<template>
  <b-modal ref="modal" id="modal-report-create" centered :title="$t('report.title')"
           @show="resetForm"
           @hidden="resetForm"
           @ok="handleOk">
    <b-form ref="form" class="row m-0 p">
      <b-form-group class="mb-0 mt-2 col-12"
                    label-cols="4"
                    content-cols="8"
                    :label="$t('report.startDate')"
                    label-for="input-startDate-date"
      >
        <b-form-datepicker class="mt-1" id="input-startDate-date" v-model="$v.form.startDate.$model"
                           start-weekday="1"
                           :locale="$t('actionAdd.datepickerLang')"
                           :state="this.$validateState('startDate')"
        ></b-form-datepicker>
        <b-form-invalid-feedback
          id="input-income-startDate-feedback">{{ $t('actionAdd.selectError') }}
        </b-form-invalid-feedback>
      </b-form-group>
      <b-form-group class="mb-0 mt-2 col-12"
                    label-cols="4"
                    content-cols="8"
                    :label="$t('report.endDate')"
                    label-for="input-endDate-date"
      >
        <b-form-datepicker class="mt-1" id="input-endDate-date" v-model="$v.form.endDate.$model"
                           start-weekday="1"
                           :locale="$t('actionAdd.datepickerLang')"
                           :state="$validateState('endDate')"
        ></b-form-datepicker>
        <b-form-invalid-feedback
          id="input-report-endDate-feedback">{{ $t('actionAdd.selectError') }}
        </b-form-invalid-feedback>
      </b-form-group>
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

import {required} from "vuelidate/lib/validators";

export default {
  name: "ReportModal",
  data() {
    return {
      form: {
        startDate: null,
        endDate: null
      },
      allFields: {
        startDate: {required},
        endDate: {required},
      }
    }
  },
  validations() {
    return this.$generatorProperties(["startDate", "endDate"], this.allFields);
  },
  methods: {
    handleOk(bvModalEvt) {
      bvModalEvt.preventDefault()
      this.handleSubmit()
    },

    resetForm() {
      this.form = this.$clearFields();
      this.$nextTick(() => {
        this.$v.$reset();
      });
    },

    async handleSubmit() {
      this.$v.form.$touch();
      if (this.$v.form.$anyError) {
        return;
      }
      const response = await this.$store.dispatch('action/GET_REPORT', this.form)
      this.$nextTick(() => {
        this.$bvModal.hide('modal-report-create')
      })
      if (response.status === "Formed") {
        this.$toast.info('Formed');
        await this.$store.commit('action/SET_REPORT', response)
        await this.$router.push('report')
      } else {
        this.$toast.error(response.status);
      }
    },

  }
}
</script>

<style scoped>

</style>
