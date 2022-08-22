import { mapActions, mapGetters } from 'vuex'
import FormSubmissionMessage from '~/components/FormSubmissionMessage.vue'
import { formMixin } from '~/mixins/formMixin'

export const submitMessagesMixin = {
  components: { FormSubmissionMessage },
  mixins: [formMixin],
  computed: {
    ...mapGetters({
      showMessage: 'formSubmissionMessage/getShowMessage',
      messageType: 'formSubmissionMessage/getMessageType',
      message: 'formSubmissionMessage/getMessage',
    }),
  },
  methods: {
    ...mapActions({
      setShowMessage: 'formSubmissionMessage/setShowMessage',
      setMessageType: 'formSubmissionMessage/setMessageType',
      setMessage: 'formSubmissionMessage/setMessage',
    }),
    hideMessage() {
      setTimeout(() => {
        this.setShowMessage(false)
      }, 6000)
    },
    showSubmitMessage(message, type) {
      this.setShowMessage(true)
      this.setMessageType(type)
      this.setMessage(message)
      this.scrollToTop()
      this.hideMessage()

      // HQ Unit Setup / Units
      const unitTabs = [['Details', 0], ['Financials', 1], ['Fees', 2]]
      for ( const [tab, key] of unitTabs ) { if(message.includes(tab)) {
        this.$store.commit('tabsView/SET_ACTIVE_TAB', key)
        this.$store.commit('tabsView/SET_ACTIVE_VALIDATE', tab) 
      }}
    },
  },
}
