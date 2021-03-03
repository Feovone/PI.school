<template>
  <div class="container  d-flex justify-content-center">
    <div v-if="report.income ===null"><h1>{{ $t('report.error') }}</h1></div>
    <b-table-simple v-else class="mt-3" bordered>
      <b-thead>
        <b-tr>
          <b-td colspan="4" class="text-center h2">{{ $t('report.title') }}</b-td>
        </b-tr>
        <b-tr>
          <b-td>{{ $t('report.startDate') }}</b-td>
          <b-td>{{ report.startDate }}</b-td>
          <b-td>{{ $t('report.endDate') }}</b-td>
          <b-td>{{ report.endDate }}</b-td>
        </b-tr>
      </b-thead>
      <b-tbody>
        <b-tr>
          <b-td>{{ $t('report.income') }}</b-td>
          <b-td colspan="2">{{ report.income }}</b-td>
          <b-td>UAH</b-td>
        </b-tr>
        <b-tr>
          <b-td>{{ $t('report.tax') }}</b-td>
          <b-td colspan="2">{{ report.tax }}</b-td>
          <b-td>UAH</b-td>
        </b-tr>
        <b-tr>
          <b-td colspan="4"> {{ $t('report.someLog') }}</b-td>
        </b-tr>
        <b-tr>
          <b-td colspan="1" class="text-center">1.</b-td>
          <b-td colspan="3"> {{ $t('report.log1') }}</b-td>
        </b-tr>
        <b-tr>
          <b-td colspan="1" class="text-center">2.</b-td>
          <b-td colspan="3"> {{ $t('report.log2') }}</b-td>
        </b-tr>
        <b-tr>
          <b-td colspan="1" class="text-center">3.</b-td>
          <b-td colspan="3"> {{ $t('report.log3') }}</b-td>
        </b-tr>

      </b-tbody>
    </b-table-simple>
  </div>
</template>

<script>

export default {
  name: "report",
  layout: 'navbar',
  middleware: 'authenticated',
  computed: {
    report() {
      return this.$store.state.action.report;
    }
  }
}

</script>

<style scoped>
.container {
  padding: 5%;
}
</style>
