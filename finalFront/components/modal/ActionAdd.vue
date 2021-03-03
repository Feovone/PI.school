<template>
  <b-modal ref="modal" size="lg" id="modal-action-add" centered :title="$t('actionAdd.title')"
           @show="resetForm"
           @hidden="resetForm"
           @ok="handleOk">
    <b-form ref="form" class="row m-0 p">
      <b-form-group class="mb-0 mt-2 col-12"
                    label-cols="4"
                    content-cols="8"
                    :label="$t('actionAdd.action')"
                    label-for="input-action"
      >
        <b-form-select id="input-action" v-model="$v.form.action.$model"
                       :options="optionsAction"
                       :state="this.$validateState('action')"></b-form-select>
        <b-form-invalid-feedback
          id="input-action-feedback">{{ $t('actionAdd.selectError') }}
        </b-form-invalid-feedback>
      </b-form-group>
      <General v-if="form.action!==null" :form="form" :validateState="validateState"/>
      <Income v-if="form.action==='income'" :form="form" :validateState="validateState"/>
      <Exchange v-if="form.action==='exchange' || form.action==='forceExchange'" :form="form"
                :validateState="validateState"/>
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
import General from "@/components/actionType/General";
import Income from "@/components/actionType/Income";
import Exchange from "@/components/actionType/Exchange";
import {validationMixin} from "vuelidate";
import {required, minLength, numeric, decimal, between} from "vuelidate/lib/validators";
import {mapState} from 'vuex';

export default {
  name: "ActionAdd",
  mixins: [validationMixin],
  data() {
    return {
      form: {
        action: null,
        sum: null,
        currency: null,
        date: null,
        forceRate: null,
        forceDate: null,
        rate: null
      },
      allFields: {
        action: {required},
        sum: {required, decimal},
        currency: {required},
        date: {required},
        forceRate: {required, decimal},
        forceDate: {required},
        rate: {required, decimal},
      }
    };
  },
  validations() {
    switch (this.form.action) {
      case 'income':
        return this.income();
      case 'exchange':
        return this.exchange();
      case 'forceExchange':
        return this.exchange();
      default:
        return this.$generatorProperties(["action"], this.allFields);
    }
  },
  computed: {
    optionsAction() {
      return [
        {value: null, text: this.$t('actionAdd.optionAction.null')},
        {value: 'income', text: this.$t('actionAdd.optionAction.income')},
        {value: 'exchange', text: this.$t('actionAdd.optionAction.exchange')},
        {value: 'forceExchange', text: this.$t('actionAdd.optionAction.forceExchange')},
      ]
    }
  },
  methods: {
    income() {
      switch (this.form.currency) {
        case 'uah':
          return this.$generatorProperties(["action", "sum", "currency", "date"], this.allFields);
        case null:
          return this.$generatorProperties(["action", "sum", "currency"], this.allFields);
        default:
          return this.$generatorProperties(["action", "sum", "currency", "date", "forceRate", "forceDate"], this.allFields);
      }
    },
    exchange() {
      return this.$generatorProperties(["action", "sum", "date", "rate"], this.allFields);
    },

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
    validateState(name) {
      return this.$validateState(name);
    },
    async handleSubmit() {
      this.$v.form.$touch();
      if (this.$v.form.$anyError) {
        return;
      }
      const response = await this.$store.dispatch('action/ADD_ACTION', this.form)
      this.$nextTick(() => {
        this.$bvModal.hide('modal-action-add')
      })
      if (response.status === "added") {
        this.$toast.info('Action added');
        await this.$store.dispatch('action/FETCH');
      } else {
        this.$toast.error(response.status);
      }

    },

  },
  watch: {
    "form.action": function () {
      if (this.form.action == 'exchange' || this.form.action == 'forceExchange')
        this.$store.dispatch('action/POSSIBLE_EXCHANGE', this.form.currency)
    }
  }
}

</script>

<style scoped>

</style>
