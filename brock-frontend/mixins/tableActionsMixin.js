
import { addPercentSign } from '~/helpers/helpers'
export const tableActionsMixin = {
  data() {
    return {
      isAdd: false,
      isEdit: false,
      isDelete: false,
      isHide: false,
    }
  },
  methods: {
    addPercentSign,
    addRow() {
      this.isHide = true
      this.isAdd = true
    },
    edit(ID) {
      this.isHide = true
      this.isEdit = ID
    },
    cancelEdit() {
      this.isHide = false
      this.isEdit = null
    },
    deleteItem(ID) {
      this.isHide = true
      this.isDelete = ID
    },
    cancelDelete() {
      this.isHide = false
      this.isDelete = null
    },
    cancelAdd() {
      this.isAdd = false
      this.isHide = false
      // this.clearState()
    },
    clearTableActionState() {
      this.isAdd = false;
      this.isEdit = false;
      this.isDelete = false;
      this.isHide = false;
    },
  },
}
