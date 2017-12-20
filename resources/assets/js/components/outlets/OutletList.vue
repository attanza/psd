<template src="./outletList.html"></template>
<script>
import {outletListUrl, storeComboUrl, outletWebUrl} from '../../globalConfig'
import paginationData from '../../mixins/paginationData';
import catchJsonErrors from '../../mixins/catchJsonErrors';
import TableSearch4 from '../slots/TableSearch4';
import TablePagination from '../slots/TablePagination';
import PlusButton from '../slots/PlusButton';
import OutletForm from './OutletForm'
export default {
  components: {
    TableSearch4, TablePagination, PlusButton, OutletForm
  },
  data () {
    return {
      outlets: [],
      stores: [],
      storeId: '',
      groupBy: 'Store',
      isEdit: false
    }
  },
  props: [
    'product_type'
  ],
  mounted() {
    this.getStores()
    this.getOutlets(this.pagination.current_page)
    this.$on('outlets', function (outlets) {
      this.outlets = outlets
    })
    this.$on('pagination', function (pagination) {
      this.pagination = pagination
      this.loading = false
    })
    this.$on('stores', function (stores) {
      this.stores = stores
    })
  },
  methods: {
    getStores () {
      axios.get(storeComboUrl).then((resp) => {
        if (resp.status === 200) {
          this.$emit('stores', resp.data)
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    getOutlets (page) {
      this.loading = true
      axios.post(outletListUrl + '?page=' + page, this.postData()).then((resp) => {
        if (resp.status === 200) {
          this.$emit('outlets', resp.data.data)
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
        storeId: this.storeId,
      }
    },
    search: _.debounce(function(data) {
      this.searchQ = data.searchQ
      this.storeId = data.comboId
      this.getOutlets(1)
    }, 500),
    changePaginate(p) {
      this.paginate = p
      this.getOutlets(1)
    },
    changePage(p) {
      this.pagination.current_page = p
      this.getOutlets(p)
    },
    prev() {
      this.pagination.current_page = this.pagination.current_page - 1
      this.getOutlets(this.pagination.current_page)
    },
    next() {
      this.pagination.current_page = this.pagination.current_page + 1
      this.getOutlets(this.pagination.current_page)
    },
    addOutlet (outlet) {
      this.outlets.unshift(outlet)
    },
    show (id) {
      window.location.href = outletWebUrl + id
    },
    formClose () {
      this.isEdit = false
      $('#outlet_form').modal('hide')
    }
  },
  mixins: [paginationData, catchJsonErrors]
}

</script>