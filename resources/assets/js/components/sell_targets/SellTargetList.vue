<template src="./sellTargetList.html"></template>
<script>
import {sellTargetListUrl, sellTargetUrl, sellTargetWebUrl} from '../../globalConfig'
import paginationData from '../../mixins/paginationData';
import catchJsonErrors from '../../mixins/catchJsonErrors';
import TableSearch from '../slots/TableSearch';
import TablePagination from '../slots/TablePagination';
import PlusButton from '../slots/PlusButton';
import TargetForm from './TargetForm'
export default {
  components: {
    TableSearch, TablePagination, PlusButton, TargetForm
  },
  data () {
    return {
      targets: [],
      isEdit: false
    }
  },
  props: [
    'products', 'areas'
  ],
  mounted() {
    this.getTargets(this.pagination.current_page)
    this.$on('targets', function (targets) {
      this.targets = targets
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
    getTargets (page) {
      this.loading = true
      axios.post(sellTargetListUrl + '?page=' + page, this.postData()).then((resp) => {
        if (resp.status === 200) {
          this.$emit('targets', resp.data.data)
          this.$emit('pagination', resp.data.meta)
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    postData () {
      return {
        searchQ: this.searchQ,
        paginate: this.paginate
      }
    },
    search: _.debounce(function(data) {
      this.searchQ = data.searchQ
      this.storeId = data.comboId
      this.gettargets(1)
    }, 500),
    changePaginate(p) {
      this.paginate = p
      this.gettargets(1)
    },
    changePage(p) {
      this.pagination.current_page = p
      this.gettargets(p)
    },
    prev() {
      this.pagination.current_page = this.pagination.current_page - 1
      this.gettargets(this.pagination.current_page)
    },
    next() {
      this.pagination.current_page = this.pagination.current_page + 1
      this.gettargets(this.pagination.current_page)
    },
    addTarget (target) {
      this.targets.unshift(target)
    },
    show (id) {
      window.location.href = userWebUrl + id
    },
    formClose () {
      this.isEdit = false
      $('#target_form').modal('hide')
    }
  },
  mixins: [paginationData, catchJsonErrors]
}

</script>