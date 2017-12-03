import { merchantForComboUrl, buildingForComboUrl, parentCategoryUrl } from '../globalConfig.js'
import _ from 'lodash'
export default {
  watch: {
    productType() {
      if (this.productType && this.productType !== '') {
        this.getMerchants()
        this.getParentCategories()
      }
    }
  },
  mounted() {
    this.axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.$auth.getToken()
    // this.getProductType()
    // this.getMerchants()
    // this.getParentCategories()
    // this.getBuildings()
  },
  methods: {
    getMerchants() {
      if (this.productType && this.productType !== '') {
        this.axios.get(merchantForComboUrl + this.productType).then((resp) => {
          console.log(resp)
          if (resp.status === 200) {
            this.$store.commit('merchants', resp.data)
          }
        }).catch((error) => {
          console.log(error.response)
        })
      }
    },
    getParentCategories() {
      if (this.productType && this.productType !== '') {
        this.axios.get(parentCategoryUrl + this.productType).then((resp) => {
          if (resp.status === 200) {
            this.$store.commit('parentCategories', resp.data)
          }
        }).catch((error) => {
          console.log(error.response)
        })
      }
    },
    checkBuilding() {
      if (this.buildings) {
        if (this.buildings.length === 0) {
          this.getBuildings()
        }
      }
    },
    getBuildings() {
      let userType = localStorage.getItem('userType')
      if (userType !== '') {
        this.axios.get(buildingForComboUrl).then((resp) => {
          if (resp.status === 200) {
            this.$store.commit('buildings', resp.data)
          }
        }).catch((error) => {
          console.log(error.response)
        })
      }
    },
    getProductType() {
      this.$store.commit('currentProductType', localStorage.getItem('productType'))
    },
    titleCase(str) {
      return _.startCase(_.toLower(str))
    }
  },
  computed: {
    buildings() {
      return this.$store.state.buildings
    },
    productType() {
      return this.$store.state.currentProductType
    }
  }
}
