<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Unit Setup / Unit Info </PageSubtitle>

      <div class="title-area">
        <PageTitle> Unit Vendor </PageTitle>

        <div class="search-area">
          <span class="search-span">Search: </span>

          <CustomInput
            v-model="searchVendor"
            placeholder="Vendor Code"
            class="search-text"
          />
        </div>
      </div>
    </template>

    <template #content>
      <HQUnitVendorContent :search="search"/>
    </template>
  </BasePageLayout>
</template>

<script>
import { HQ_UNITS_TABS } from '~/constants/constants'
import { unitMaintenanceMixin } from '~/mixins/unitMaintenanceMixin'
import { sideBarNavTabsMixin } from '~/mixins/sideBarNavTabsMixin'
import BasePageLayout from '~/components/BasePageLayout.vue'
import SideBar from '~/components/SideBar.vue'
import PageSubtitle from '~/components/PageSubtitle.vue'
import PageTitle from '~/components/PageTitle.vue'
import HQUnitVendorContent from '~/components/HQUnitVendorContent'
export default {
  name: 'UnitVendorPage',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    HQUnitVendorContent,
  },
  mixins: [unitMaintenanceMixin, sideBarNavTabsMixin(HQ_UNITS_TABS)],
  layout: 'hqlayout',
  data() {
    return {
      search: ''
    }
  },
  computed: {
    searchVendor: {
      get() {
        return this.search
      },
      set(value) {
        this.search = value
      }
    }
  },
  created() {
    this.$store.commit('sidebar/SET_MENU', this.navTabs)
  }
}
</script>

<style lang="scss" scoped>
.title-area {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.search-area {
  display: flex;
  align-items: center;

  .search-span, .search-text {
    margin-right: 10px;
  }
}
</style>
