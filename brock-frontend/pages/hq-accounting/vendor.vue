<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Accounting / Vendor </PageSubtitle>

      <div class="title-area">
        <PageTitle> Vendor </PageTitle>

        <div class="search-area">
          <span class="search-span">Search: </span>

          <CustomInput
            v-model="searchVendor"
            placeholder="Vendor Code"
          />
        </div>
      </div>
    </template>

    <template #content>
      <HQVendorContent :search="search" />
    </template>
  </BasePageLayout>
</template>

<script>
import { HQ_ACCOUNTING } from '~/constants/constants'
import { sideBarNavTabsMixin } from '~/mixins/sideBarNavTabsMixin'
import BasePageLayout from '~/components/BasePageLayout.vue'
import SideBar from '~/components/SideBar.vue'
import PageSubtitle from '~/components/PageSubtitle.vue'
import PageTitle from '~/components/PageTitle.vue'
import HQVendorContent from '~/components/HQVendorContent.vue'
export default {
  name: 'VendorPage',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    HQVendorContent,
  },
  mixins: [sideBarNavTabsMixin(HQ_ACCOUNTING)],
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

  .search-span {
    margin-right: 10px;
  }
}
</style>
