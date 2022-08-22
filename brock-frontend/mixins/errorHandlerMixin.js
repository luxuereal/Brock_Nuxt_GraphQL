export const errorHandlerMixin = {
  methods: {
    handleError(errors) {
      errors.forEach((error) => {
        if (error.extensions.status) {
          this.showSubmitMessage(error.extensions.status, 'error')
        } else {
          this.showSubmitMessage(error.message, 'error')
        }
      })
    },
  },
}
