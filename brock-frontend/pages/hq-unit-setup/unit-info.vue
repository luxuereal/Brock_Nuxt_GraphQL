<template>
  <BasePageLayout>
    <template #sideBar>
      <SideBar :nav-tabs="navTabs" />
    </template>

    <template #header>
      <PageSubtitle> Unit Setup / Unit Info </PageSubtitle>

      <div class="title-area">
        <PageTitle> Unit Maintenance </PageTitle>

        <div class="search-area">
          <span class="search-span">Search: </span>

          <CustomInput
            v-model="searchUnit"
            placeholder="Unit Code"
            class="search-text"
          />

          <DefaultButton button-color-gamma="red" @event="addUnit">
            + Add unit
          </DefaultButton>
        </div>
      </div>
    </template>

    <template #content>
      <component :is="isShowAddUnit" :search="search" />
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
import DefaultButton from '~/components/DefaultButton.vue'
import { UNIT } from '~/constants/unit'
export default {
  name: 'UnitInfoPage',
  components: {
    BasePageLayout,
    SideBar,
    PageSubtitle,
    PageTitle,
    DefaultButton,
  },
  mixins: [unitMaintenanceMixin, sideBarNavTabsMixin(HQ_UNITS_TABS)],
  layout: 'hqlayout',
  data() {
    return {
      search: ''
    }
  },
  computed: {
    searchUnit: {
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
  },
  methods: {
    addUnit() {
      this.$store.dispatch('unitMaintenance/setUnit', { ...UNIT })
      this.setUnitID(null)
      this.showAddUnit()
    },
  },
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
