<template src="./userList.html"></template>
<script>
import {userListUrl, storeComboUrl, userWebUrl} from '../../globalConfig'
import paginationData from '../../mixins/paginationData';
import catchJsonErrors from '../../mixins/catchJsonErrors';
import TableSearch from '../slots/TableSearch';
import TablePagination from '../slots/TablePagination';
import PlusButton from '../slots/PlusButton';
import UserForm from './UserForm'
export default {
  components: {
    TableSearch, TablePagination, PlusButton, UserForm
  },
  data () {
    return {
      users: [],
      isEdit: false
    }
  },
  props: [
    'product_type'
  ],
  mounted() {
    this.getUsers(this.pagination.current_page)
    this.$on('users', function (users) {
      this.users = users
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
    getUsers (page) {
      this.loading = true
      axios.post(userListUrl + '?page=' + page, this.postData()).then((resp) => {
        if (resp.status === 200) {
          this.$emit('users', resp.data.data)
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
      this.getUsers(1)
    }, 500),
    changePaginate(p) {
      this.paginate = p
      this.getUsers(1)
    },
    changePage(p) {
      this.pagination.current_page = p
      this.getUsers(p)
    },
    prev() {
      this.pagination.current_page = this.pagination.current_page - 1
      this.getUsers(this.pagination.current_page)
    },
    next() {
      this.pagination.current_page = this.pagination.current_page + 1
      this.getUsers(this.pagination.current_page)
    },
    addUser (user) {
      this.users.unshift(user)
    },
    show (id) {
      window.location.href = userWebUrl + id
    },
    formClose () {
      this.isEdit = false
      $('#user_form').modal('hide')
    }
  },
  mixins: [paginationData, catchJsonErrors]
}

</script>