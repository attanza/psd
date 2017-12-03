<template src="./areaList.html"></template>
<script>
import {areaListUrl} from '../../globalConfig'
import paginationData from '../../mixins/paginationData';
import catchJsonErrors from '../../mixins/catchJsonErrors';
import TableSearch from '../slots/TableSearch';
import TablePagination from '../slots/TablePagination';
import PlusButton from '../slots/PlusButton';
import AreaForm from './AreaForm'
export default {
  components: {
    TableSearch, TablePagination, PlusButton
  },
  data () {
    return {
      areas: [],
      isEdit: false
    }
  },
  props: [
    'product_type'
  ],
  mounted() {
    this.getAreas(this.pagination.current_page)
    this.$on('areas', function (areas) {
      this.areas = areas
    })
    this.$on('pagination', function (pagination) {
      this.pagination = pagination
      this.loading = false
    })
  },
  methods: {
    getAreas (page) {
      this.loading = true
      axios.post(areaListUrl + '?page=' + page, this.postData()).then((resp) => {
        if (resp.status === 200) {
          this.$emit('areas', resp.data.data)
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
      }
    },
    search: _.debounce(function(data) {
      this.searchQ = data
      this.getAreas(1)
    }, 500),
    changePaginate(p) {
      this.paginate = p
      this.getAreas(1)
    },
    changePage(p) {
      this.pagination.current_page = p
      this.getAreas(p)
    },
    prev() {
      this.pagination.current_page = this.pagination.current_page - 1
      this.getAreas(this.pagination.current_page)
    },
    next() {
      this.pagination.current_page = this.pagination.current_page + 1
      this.getAreas(this.pagination.current_page)
    },
    addArea (area) {
      this.areas.unshift(area)
    },
    updateArea (area) {
      let index = _.findIndex(this.areas, function (c) {
        return c.id === area.id
      })
      this.areas.splice(index, 1, area)
      this.isEdit = false
      $('#area_form').modal('hide')
    },
    show (area) {
      this.$store.commit('currentArea', area)
      this.isEdit = true
      $('#area_form').modal('show')

    },
    formClose () {
      this.isEdit = false
      $('#area_form').modal('hide')
      
    }
  },
  mixins: [paginationData, catchJsonErrors]
}

</script>