<template>
  <div class="col-12 p-0">
    <b-form-group class="mb-0 mt-2 col-12"
                  id="fieldset-horizontal"
                  label-cols="4"
                  content-cols="8"
                  :label="$t('actionAdd.sum')"
                  label-for="input-sum"

    >

      <b-form-input class="mt-1" id="input-sum" v-model="$v.form.sum.$model"
                    :state="validateState('sum')"
                    :placeholder="possibleSum">
      </b-form-input>
      <b-form-invalid-feedback
        id="input-sum-feedback">{{ $t('actionAdd.enterError') }}
      </b-form-invalid-feedback>
    </b-form-group>

    <b-form-group class="mb-0 mt-2 col-12"
                  label-cols="4"
                  content-cols="8"
                  :label="$t('actionAdd.currency')"
                  label-for="input-currency"
    >
      <b-form-select v-if="form.action==='exchange'||form.action==='forceExchange'" id="input-currency"
                     v-model="$v.form.currency.$model='usd'"
                     disabled
                     :options="optionsCurrency"
                     :state="validateState('currency')">
      </b-form-select>
      <b-form-select v-else id="input-currency" v-model="$v.form.currency.$model"
                     :options="optionsCurrency"
                     :state="validateState('currency')">
      </b-form-select>
      <b-form-invalid-feedback
        id="input-currency-feedback">{{ $t('actionAdd.selectError') }}
      </b-form-invalid-feedback>
    </b-form-group>

  </div>
</template>

<script>
import {required} from "vuelidate/lib/validators";
import {decimal} from "vuelidate/lib/validators";

export default {
  name: "General",
  props: ['form', 'validateState'],
  data() {
    return {
      optionsCurrency: [
        {value: null, text: this.$t('actionAdd.optionCurrency.null')},
        {value: 'uah', text: this.$t('actionAdd.optionCurrency.uah')},
        {value: 'usd', text: this.$t('actionAdd.optionCurrency.usd')},
      ],
    }
  },

  validations: {
    form: {
      sum: {},
      currency: {},

    },
  },
  computed: {
    possibleSum() {
      if (this.form.action == 'exchange') {
        return this.$store.state.action.possibleCurrency.sum
      }
    }

  },

}

</script>

<style scoped>

</style>
