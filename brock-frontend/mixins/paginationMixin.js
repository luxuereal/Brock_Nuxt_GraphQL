export const pageSize = 20

export const paginationMixin = {
  data() {
    return {
      page: 1,
    }
  },
  methods: {
    fetchMore(query) {
      window.onscroll = () => {
        const bottomOfWindow =
          document.documentElement.scrollTop + window.innerHeight ===
          document.documentElement.offsetHeight
        const lastPage = this[query].paginatorInfo.lastPage

        if (bottomOfWindow && lastPage !== this.page) {
          this.page++
          this.$apollo.queries[query].fetchMore({
            variables: {
              page: this.page,
              first: pageSize,
            },

            updateQuery: (previousResult, { fetchMoreResult }) => {
              const newData = fetchMoreResult[query].data
              const paginatorInfo = fetchMoreResult[query].paginatorInfo

              return {
                cities: {
                  __typename: previousResult[query].__typename,
                  data: [...previousResult[query].data, ...newData],
                  paginatorInfo: {
                    ...paginatorInfo,
                  },
                },
              }
            },
          })
        }
      }
    },
  },
}
