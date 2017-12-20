<template src="./roleList.html"></template>
<script>
import {roleListUrl} from '../../globalConfig'
import paginationData from '../../mixins/paginationData';
import catchJsonErrors from '../../mixins/catchJsonErrors';
import TableSearch from '../slots/TableSearch';
import TablePagination from '../slots/TablePagination';
import PlusButton from '../slots/PlusButton';
import RoleForm from './RoleForm'
export default {
  components: {
    TableSearch, TablePagination, PlusButton, RoleForm
  },
  data () {
    return {
      roles: [],
      isEdit: false
    }
  },
  props: [
    'product_type'
  ],
  mounted() {
    this.getRoles(this.pagination.current_page)
    this.$on('roles', function (roles) {
      this.roles = roles
    })
    this.$on('pagination', function (pagination) {
      this.pagination = pagination
      this.loading = false
    })
  },
  methods: {
    getRoles (page) {
      this.loading = true
      axios.post(roleListUrl + '?page=' + page, this.postData()).then((resp) => {
        if (resp.status === 200) {
          this.$emit('roles', resp.data.data)
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
      this.getRoles(1)
    }, 500),
    changePaginate(p) {
      this.paginate = p
      this.getRoles(1)
    },
    changePage(p) {
      this.pagination.current_page = p
      this.getRoles(p)
    },
    prev() {
      this.pagination.current_page = this.pagination.current_page - 1
      this.getRoles(this.pagination.current_page)
    },
    next() {
      this.pagination.current_page = this.pagination.current_page + 1
      this.getRoles(this.pagination.current_page)
    },
    addRole (role) {
      this.roles.unshift(role)
    },
    updateRole (role) {
      let index = _.findIndex(this.roles, function (r) {
        return r.id === role.id
      })
      this.roles.splice(index, 1, role)
      this.isEdit = false
      $('#role_form').modal('hide')
    },
    show (role) {
      this.$store.commit('currentRole', role)
      this.isEdit = true
      $('#role_form').modal('show')

    },
    formClose () {
      this.isEdit = false
      $('#role_form').modal('hide')
      
    }
  },
  mixins: [paginationData, catchJsonErrors]
}

</script>