<template>
  <div class="col-12 p-0">
    <b-form-group class="mb-0 mt-2 col-12"
                  label-cols="4"
                  content-cols="8"
                  label-for="input-exchange-rate"
                  v-if="form.currency!=='uah'"
                  :label="$t('actionAdd.exchange.rate')"
    >
      <b-form-input class="mt-1" id="input-exchange-rate"
                    v-model="$v.form.rate.$model"
                    :state="validateState('rate')"></b-form-input>
      <b-form-invalid-feedback id="input-exchange-rate-feedback">
        {{ $t('actionAdd.enterError') }}
      </b-form-invalid-feedback>
    </b-form-group>
    <b-form-group class="mb-0 mt-2 col-12"
                  label-cols="4"
                  content-cols="8"
                  :label="$t('actionAdd.income.date')"
                  label-for="input-income-date"
    >
      <b-form-datepicker class="mt-1" id="input-income-date" v-model="$v.form.date.$model"
                         start-weekday="1"
                         :max="maxDate"
                         :locale="$t('actionAdd.datepickerLang')"
                         :state="validateState('date')"
      ></b-form-datepicker>
      <b-form-invalid-feedback id="input-exchange-date-feedback">
        {{ $t('actionAdd.selectError') }}
      </b-form-invalid-feedback>
    </b-form-group>
  </div>
</template>

<script>
export default {
  name: "Exchange",
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
      rate: {},
      date: {},
    }
  }
}
</script>

<style scoped>

</style>
