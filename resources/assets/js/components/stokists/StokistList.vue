<template src="./stokistList.html"></template>
<script>
import {stokistListUrl, areaComboUrl, stokistWebUrl} from '../../globalConfig'
import paginationData from '../../mixins/paginationData';
import catchJsonErrors from '../../mixins/catchJsonErrors';
import TableSearch4 from '../slots/TableSearch4';
import TablePagination from '../slots/TablePagination';
import PlusButton from '../slots/PlusButton';
import StokistForm from './StokistForm'
export default {
  components: {
    TableSearch4, TablePagination, PlusButton, StokistForm
  },
  data () {
    return {
      stokists: [],
      areas: [],
      areaId: '',
      groupBy: 'Area',
      isEdit: false
    }
  },
  props: [
    'product_type'
  ],
  mounted() {
    this.getAreas()
    this.getstokists(this.pagination.current_page)
    this.$on('stokists', function (stokists) {
      this.stokists = stokists
    })
    this.$on('pagination', function (pagination) {
      this.pagination = pagination
      this.loading = false
    })
    this.$on('areas', function (areas) {
      this.areas = areas
    })
  },
  methods: {
    getAreas () {
      axios.get(areaComboUrl).then((resp) => {
        if (resp.status === 200) {
          this.$emit('areas', resp.data)
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    getstokists (page) {
      this.loading = true
      axios.post(stokistListUrl + '?page=' + page, this.postData()).then((resp) => {
        if (resp.status === 200) {
          this.$emit('stokists', resp.data.data)
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
        areaId: this.areaId,
      }
    },
    search: _.debounce(function(data) {
      this.searchQ = data.searchQ
      this.areaId = data.comboId
      this.getstokists(1)
    }, 500),
    changePaginate(p) {
      this.paginate = p
      this.getstokists(1)
    },
    changePage(p) {
      this.pagination.current_page = p
      this.getstokists(p)
    },
    prev() {
      this.pagination.current_page = this.pagination.current_page - 1
      this.getstokists(this.pagination.current_page)
    },
    next() {
      this.pagination.current_page = this.pagination.current_page + 1
      this.getstokists(this.pagination.current_page)
    },
    addStokist (stokist) {
      this.stokists.unshift(stokist)
    },
    show (id) {
      window.location.href = stokistWebUrl + id
    },
    formClose () {
      this.isEdit = false
      $('#stokist_form').modal('hide')
      
    }
  },
  mixins: [paginationData, catchJsonErrors]
}

</script>