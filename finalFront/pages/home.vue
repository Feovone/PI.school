<template>
  <div class="container mt-4">
    <div class="row">
      <div class="col-10">
        <h1>{{ $t('home.action') }}:</h1>
      </div>

      <div class="col-2  my-auto">
        <b-button type="button" v-if="isActionsSelected" class="btn btn-primary  px-3" v-b-modal.modal-action-add>
          {{ $t('home.addAction') }}
        </b-button>
        <b-button v-else @click="deleteActions">{{ $t('home.delAction') }}</b-button>
      </div>
    </div>
    <ActionAdd/>
    <ActionTable/>
  </div>
</template>

<script>
import {BIconArrowUp} from 'bootstrap-vue'
import ActionTable from "../components/ActionTable";
import ActionAdd from "../components/modal/ActionAdd";

export default {
  name: "home",
  layout: 'navbar',
  middleware: 'authenticated',
  async fetch({store}) {
    await store.dispatch('action/FETCH');
  },
  computed: {
    isActionsSelected() {
      return this.$store.getters['action/isActionsSelected']
    },
    activeActions() {
      return this.$store.state.action.activeActions
    }
  },
  methods: {
    async deleteActions() {
      const response = await this.$store.dispatch('action/DELETE_ACTION', this.activeActions)

      if (response.status === "deleted") {
        await this.$store.dispatch('action/fetch');
      }
    }

  }
}
</script>

<style scoped>
.btn-primary {
  background-color: #6C63FF !important;
  border-color: #6C63FF;
}

</style>
