<template>
  <div class="col-12 p-0" v-if="form.currency!=null">
    <b-form-group class="mb-0 mt-2 col-12"
                  label-cols="4"
                  content-cols="8"
                  :label="$t('actionAdd.income.date')"
                  label-for="input-income-date"
    >
      <b-form-datepicker class="mt-1" id="input-income-date" v-model="$v.form.date.$model"
                         start-weekday="1"
                         :locale="$t('actionAdd.datepickerLang')"
                         :state="validateState('date')"
                         :max="maxDate"
      ></b-form-datepicker>
      <b-form-invalid-feedback
        id="input-income-date-feedback">{{ $t('actionAdd.selectError') }}
      </b-form-invalid-feedback>
    </b-form-group>
    <div class="col-12 p-0" v-if="$auth.user.force_exchange_flag==1">
      <b-form-group class="mb-0 mt-2 col-12"
                    label-cols="4"
                    content-cols="8"
                    label-for="input-force-rate"
                    v-if="form.currency!=='uah'"
                    :label="$t('actionAdd.income.forceRate',{currency:form.currency})"
      >
        <b-form-input class="mt-1" id="input-income-rate"
                      v-model="$v.form.forceRate.$model"
                      :state="validateState('forceRate')"></b-form-input>
        <b-form-invalid-feedback
          id="input-income-force-rate-feedback">{{ $t('actionAdd.enterError') }}
        </b-form-invalid-feedback>
      </b-form-group>
      <b-form-group class="mb-0 mt-2 col-12"
                    id="fieldset-horizontal"
                    label-cols="4"
                    content-cols="8"
                    label-for="input-income-exchange-rate"
                    v-if="form.currency!=='uah'"
                    :label="$t('actionAdd.income.forceDate',{currency:form.currency})"
      >
        <b-form-datepicker class="mt-1" id="input-income-force-date"
                           v-model="$v.form.forceDate.$model"
                           start-weekday="1"
                           :locale="$t('actionAdd.datepickerLang')"
                           :state="this.$validateState('forceDate')"
                           :max="maxDate"
        ></b-form-datepicker>
        <b-form-invalid-feedback
          id="input-income-force-date-feedback">{{ $t('actionAdd.selectError') }}
        </b-form-invalid-feedback>
      </b-form-group>
    </div>
  </div>
</template>

<script>

export default {
  name: "Income",
  props: ['form', 'validateState'],
  data() {
    const now = new Date()
    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate())
    return {
      maxDate: new Date(today)
    }
  },
  validations: {
    form: {
      date: {},
      forceRate: {},
      forceDate: {},
    }
  }
}
</script>

<style scoped>

</style>
