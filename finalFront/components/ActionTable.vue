<template>
  <div class="p-0 mt-4 col-12">
    <b-table class="mb-0" hover
             id="action-table"
             small
             bordered
             outlined
             selectable
             select-mode="single"
             sort-icon-left
             :items="actions"
             :per-page="perPage"
             :current-page="currentPage"
             :fields="fields"
             @row-selected="onRowSelected"
    >
      <template #cell(index)="data">
        {{ data.index + 1 }}
      </template>
    </b-table>
    <b-pagination align="center" class="mt-4 border-1"
                  v-model="currentPage"
                  :total-rows="rows"
                  :per-page="perPage"
                  aria-controls="action-table"
    ></b-pagination>

  </div>
</template>

<script>
export default {
  name: "ActionTable",
  data() {
    return {
      currentPage: 1,
      perPage: 15,
    }
  },
  computed: {
    actions() {
      return this.$store.state.action.actions
    },
    rows() {
      return this.actions.length
    },
    fields() {
      return [
        {
          key: 'index',
          label: '#',
        },
        {
          key: 'kind_action',
          label: this.$i18n.t('home.table.action'),
          sortable: true
        },
        {
          key: 'sum',
          label: this.$i18n.t('home.table.sum'),
          sortable: true
        },
        {
          key: 'currency',
          label: this.$i18n.t('home.table.currency'),
          sortable: true
        },
        {
          key: 'description',
          label: this.$i18n.t('home.table.description'),
          sortable: true
        },
        {
          key: 'date',
          label: this.$i18n.t('home.table.date'),
          sortable: true,
          formatter: 'dateFormat'
        }
      ]
    },

  },
  methods: {
    dateFormat(value) {
      return new Date(value).toLocaleDateString()
    },
    onRowSelected(rows) {
      this.$store.commit('action/SET_ACTIVE_ACTIONS', rows);
    },
  },


}
</script>

<style>
</style>
