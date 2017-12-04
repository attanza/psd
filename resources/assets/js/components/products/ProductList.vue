<template>
<div id="product_list"
     class="container-fluid">
  <table-search :perPages="perPages"
                :loading="loading"
                :paginate="paginate"
                @search="search"
                @changePaginate="changePaginate"></table-search>
  <div class="row"
       v-for="chunk in products">
    <div class="col-md-4"
         v-for="product in chunk">
      <div class="box">
        <div class="box-body">
          <a href="javascript:void(0)" @click="show(product.id)">
            <div class="image-wrapper"
             v-bind:style="{ 'background-image': 'url(' + product.photo + ')' }"></div>
          </a>
        </div>
        <div class="box-footer">
          <h4>{{product.name}}</h4>
        </div>
      </div>
    </div>
  </div>
  <table-pagination :pagination="pagination"
                    @changePage="changePage"
                    @prev="prev"
                    @next="next"></table-pagination>
  <plus-button target="product_form"></plus-button>
  <product-form @onAdd="onAdd"></product-form>
</div>

</template>

<script>
import { productListUrl, productWebUrl } from '../../globalConfig';
import paginationData from '../../mixins/paginationData';
import catchJsonErrors from '../../mixins/catchJsonErrors';
import TableSearch from '../slots/TableSearch';
import TablePagination from '../slots/TablePagination';
import PlusButton from '../slots/PlusButton';
import ProductForm from './ProductForm';
export default {
  components: {
    TableSearch,
    TablePagination,
    PlusButton,
    ProductForm
  },
  data() {
    return {
      products: [],
      paginate: 9,
      perPages: [9,27,36]
    }
  },
  mounted() {
    this.getProducts(this.pagination.current_page)
    this.$on('products', function(products) {
      this.products = _.chunk(products, 3)
      this.perPageDisabled = false
    })
    this.$on('pagination', function(pagination) {
      this.pagination = pagination
      this.loading = false
    })
  },
  methods: {
    getProducts(page) {
      this.loading = true
      axios.post(productListUrl + '?page=' + page, this.postData()).then((resp) => {
        if (resp.status === 200) {
          this.$emit('products', resp.data.data)
          this.$emit('pagination', resp.data.meta)
        }
      }).catch(error => {
        this.catchError(error.response)
      })
    },
    search: _.debounce(function(p) {
      this.searchQ = p
      this.getProducts(1)
    }, 300),
    changePaginate(p) {
      this.paginate = p
      this.getProducts(1)
    },
    changePage(p) {
      this.pagination.current_page = p
      this.getProducts(p)
    },
    postData() {
      return {
        searchQ: this.searchQ,
        paginate: this.paginate
      }
    },
    prev() {
      this.pagination.current_page = this.pagination.current_page - 1
      this.getProducts(this.pagination.current_page)
    },
    next() {
      this.pagination.current_page = this.pagination.current_page + 1
      this.getProducts(this.pagination.current_page)
    },
    show(id) {
      window.location.href = productWebUrl + id
    },
    onAdd(p) {
      this.products.unshift(p)
    }
  },
  mixins: [
    paginationData, catchJsonErrors
  ]
}

</script>
<style type="text/css" scoped>
  .image-wrapper {
    min-height: 300px;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    overflow: hidden;
    border-radius: 5px;
  }
/*  .box-footer {
    background-color: #3c8dbc;
    color: #fff
  }*/
</style>