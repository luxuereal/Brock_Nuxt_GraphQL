import {
  mapActions,
  mapGetters,
} from 'vuex'
import { UNIT } from '~/constants/unit'

export const unitMaintenanceMixin = {
  computed: {
    ...mapGetters({
      isShowAddUnit: 'unitMaintenance/getShowAddUnit',
      unitID: 'unitMaintenance/getUnitID',
      unit: 'unitMaintenance/getUnit',
      unitFromAPI: 'unitMaintenance/getUnitFromApi',
      unitStateFromAPI: 'unitMaintenance/getUnitStateFromAPI',
      unitState: 'unitMaintenance/getUnitState',
    }),
  },
  methods: {
    ...mapActions({
      setShowAddUnit: 'unitMaintenance/setShowAddUnit',
      setUnit: 'unitMaintenance/setUnit',
      setUnitID: 'unitMaintenance/setUnitID',
    }),
    showAddUnit() {
      this.setShowAddUnit('HQUnitMaintenance')
    },
    hideAddUnit() {
      this.$store.dispatch('unitMaintenance/setUnit', { ...UNIT })
      this.setShowAddUnit('HQUnitsTableContent')
    },
    cancel() {
      this.cancelEvent()
      this.hideAddUnit()
      this.setUnitID(null)
      this.setUnit({ ...UNIT })
    },
  },
}
