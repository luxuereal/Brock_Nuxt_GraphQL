<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs"/>
    </template>

    <template #header>
      <PageSubtitle> Accounting / Roles</PageSubtitle>

      <div class="title-area">
        <PageTitle> Roles</PageTitle>
        <DefaultButton v-if="isShowAddRole === 'HQRoles'" button-color-gamma="red" @event="addRoles">
          + Add role
        </DefaultButton>
      </div>
    </template>

    <template #content>
      <HQRolesContent/>
    </template>
  </BasePageLayout>
</template>

<script>
import { mapGetters, mapActions } from "vuex"
import {HQ_ACCOUNTING} from '~/constants/constants'
import {sideBarNavTabsMixin} from '~/mixins/sideBarNavTabsMixin'
import BasePageLayout from '~/components/BasePageLayout.vue'
import SideBar from '~/components/SideBar.vue'
import PageSubtitle from '~/components/PageSubtitle.vue'
import PageTitle from '~/components/PageTitle.vue'
import HQRolesContent from '~/components/HQRolesContent/HQRolesContent.vue'
import DefaultButton from '~/components/DefaultButton.vue'

export default {
  name: "RolesPage",
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    HQRolesContent,
    DefaultButton
  },
  mixins: [sideBarNavTabsMixin(HQ_ACCOUNTING)],
  layout: 'hqlayout',
  computed: {
    ...mapGetters({
      isShowAddRole: 'roles/getShowAddRole',
      isUpdateRole: 'roles/getUpdateRole'
    }),
  },
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  },
  methods:{
    ...mapActions({
      setShowAddRole: 'roles/setShowAddRole',
    }),
    addRoles(){
        this.setShowAddRole('HQRolesCreate')
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
