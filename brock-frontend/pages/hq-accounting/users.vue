<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs"/>
    </template>

    <template #header>
      <PageSubtitle> Accounting / Users</PageSubtitle>

      <div class="title-area">
        <PageTitle> Users</PageTitle>
        <DefaultButton v-if="isShowAddUser == 'HQUsers'" button-color-gamma="red" @event="addUsers">
          + Add user
        </DefaultButton>
      </div>
    </template>

    <template #content>
      <HQUsersContent/>
    </template>
  </BasePageLayout>
</template>

<script>
import {mapActions, mapGetters} from "vuex"
import {HQ_ACCOUNTING} from '~/constants/constants'
import {sideBarNavTabsMixin} from '~/mixins/sideBarNavTabsMixin'
import BasePageLayout from '~/components/BasePageLayout.vue'
import SideBar from '~/components/SideBar.vue'
import PageSubtitle from '~/components/PageSubtitle.vue'
import PageTitle from '~/components/PageTitle.vue'
import HQUsersContent from '~/components/HQUsersContent/HQUsersContent.vue'
import DefaultButton from '~/components/DefaultButton.vue'


export default {
  name: "UsersPage",
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    HQUsersContent,
    DefaultButton
  },
  mixins: [sideBarNavTabsMixin(HQ_ACCOUNTING)],
  layout: 'hqlayout',
  computed: {
    ...mapGetters({
      isShowAddUser: 'users/getShowAddUser',
    }),
  },
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  },
  methods:{
    ...mapActions({
      setShowAddUser: 'users/setShowAddUser',
    }),
    addUsers(){
        this.setShowAddUser('HQUsersCreate')
    }
  }
}
</script>

<style lang="scss" scoped>
.title-area {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
</style>
