export const glAccountMixin = {
  methods: {
    getItemIdWithGLAccount(glAccount) {
      if(glAccount.parent === null || glAccount.parent === undefined) {
        return `${glAccount.itemId}—000`
      }else {
        return `${glAccount.parent.itemId}—${glAccount.itemId}`
      }
    },
    getNameWithGLAccount(glAccount) {
      if(glAccount.parent === null || glAccount.parent === undefined) {
        return `${glAccount.itemId}—000 — ${glAccount.name}`
      }else {
        return `${glAccount.parent.itemId}—${glAccount.itemId} — ${glAccount.name}`
      }
    },
  },
}
