import { mapActions } from 'vuex'

export const formMixin = {
  methods: {
    ...mapActions({
      setShowMessage: 'formSubmissionMessage/setShowMessage',
      setMessageType: 'formSubmissionMessage/setMessageType',
    }),
    clearState() {
      Object.assign(this.$data, this.$options.data.apply(this))
      this.$refs.form && this.$refs.form.reset()
    },
    scrollToTop() {
      window.scrollTo(0, 0)
    },
    cancelEvent() {
      if (this.$refs.form) {
        this.$refs.form.reset()
        this.clearState()
        setTimeout(() => {
          this.setShowMessage(false)
        }, 4000)
      }
    },
    saveEvent() {
      this.$refs.form.validate().then((result) => {
        if (result) {
          this.setShowMessage(true)
          this.setMessageType('success')
          this.scrollToTop()
          setTimeout(() => {
            this.clearState()
            this.$refs.form.reset()
          }, 4000)
        } else {
          this.setShowMessage(true)
          this.setMessageType('error')
          this.scrollToTop()
        }

        setTimeout(() => {
          this.setShowMessage(false)
        }, 4000)
      })
    },
  },
}
