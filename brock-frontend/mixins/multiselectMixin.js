import Multiselect from 'vue-multiselect'

export const multiselectMixin = {
  components: { Multiselect },
  methods: {
    nameWithId({ name, code, id }) {
      if(code === undefined) {
        return `${id} — ${name}`
      }else {
        return `${code} — ${name}`
      }
    },
  },
}
