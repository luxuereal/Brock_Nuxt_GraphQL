export const resultHandlerMixin = {
  methods: {
    handleResult(result, queryObject) {
      this.showSubmitMessage(result.data[queryObject].message, 'success')
    },
  },
}
