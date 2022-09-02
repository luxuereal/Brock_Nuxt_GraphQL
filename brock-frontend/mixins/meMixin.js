import Me from '~/graphql/queries/me.query.gql'
export const meMixin = {
  apollo: {
    me: {
      query: Me,
      // pollInterval: 700,
    },
  },
  computed: {
    selectedUnit() {
      return this.me && this.me.selectedUnit
    },
    periodEndDate() {
      return this.selectedUnit && this.selectedUnit.activePeriod.periodEnd
    },
    calculationVariables() {
      return {
        unitId: this.selectedUnit && Number(this.selectedUnit.id),
        periodId:
          this.selectedUnit && Number(this.selectedUnit.activePeriod.id),
      }
    },
    periods() {
      return this.selectedUnit && this.selectedUnit.periods
    },
  },
}
