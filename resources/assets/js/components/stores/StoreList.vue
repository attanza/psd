<template src="./storeList.html"></template>
<script>
import {storeListUrl, marketComboUrl, storeWebUrl} from '../../globalConfig'
import paginationData from '../../mixins/paginationData';
import catchJsonErrors from '../../mixins/catchJsonErrors';
import TableSearch4 from '../slots/TableSearch4';
import TablePagination from '../slots/TablePagination';
import PlusButton from '../slots/PlusButton';
import StoreForm from './StoreForm'
export default {
  components: {
    TableSearch4, TablePagination, PlusButton, StoreForm
  },
  data () {
    return {
      stores: [],
      markets: [],
      marketId: '',
      groupBy: 'Market',
      isEdit: false
    }
  },
  props: [
    'product_type'
  ],
  mounted() {
    this.getMarkets()
    this.getStores(this.pagination.current_page)
    this.$on('stores', function (stores) {
      this.stores = stores
    })
    this.$on('pagination', function (pagination) {
      this.pagination = pagination
      this.loading = false
    })
    this.$on('markets', function (markets) {
      this.markets = markets
    })
  },
  methods: {
    getMarkets () {
      axios.get(marketComboUrl).then((resp) => {
        if (resp.status === 200) {
          this.$emit('markets', resp.data)
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    getStores (page) {
      this.loading = true
      axios.post(storeListUrl + '?page=' + page, this.postData()).then((resp) => {
        if (resp.status === 200) {
          this.$emit('stores', resp.data.data)
          this.$emit('pagination', resp.data.meta)
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    postData () {
      return {
        searchQ: this.searchQ,
        paginate: this.paginate,
        marketId: this.marketId,
      }
    },
    search: _.debounce(function(data) {
      this.searchQ = data.searchQ
      this.marketId = data.comboId
      this.getStores(1)
    }, 500),
    changePaginate(p) {
      this.paginate = p
      this.getStores(1)
    },
    changePage(p) {
      this.pagination.current_page = p
      this.getStores(p)
    },
    prev() {
      this.pagination.current_page = this.pagination.current_page - 1
      this.getStores(this.pagination.current_page)
    },
    next() {
      this.pagination.current_page = this.pagination.current_page + 1
      this.getStores(this.pagination.current_page)
    },
    addStore (store) {
      this.stores.unshift(store)
    },
    show (id) {
      window.location.href = storeWebUrl + id
    },
    formClose () {
      this.isEdit = false
      $('#store_form').modal('hide')
    }
  },
  mixins: [paginationData, catchJsonErrors]
}

</script>