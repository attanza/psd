<template>
<div class="box box-danger box-solid">
  <div class="box-header with-border">
    <h3 class="box-title">Product Info</h3>
    <div class="box-tools pull-right">
      <button type="button"
              class="btn btn-box-tool"
              @click="editProduct"><i class="fa fa-pencil"></i></button>
    </div>
  </div>
  <div class="box-body">
    <table class="table">
      <tbody>
        <tr>
          <th width="30%">Code</th>
          <td width="70%">{{product.code}}</td>
        </tr>
        <tr>
          <th>Name</th>
          <td>{{product.name}}</td>
        </tr>
        <tr>
          <th>Measurement</th>
          <td>{{product.measurement}}</td>
        </tr>
        <tr>
          <th>Price</th>
          <td>{{product.price}}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <product-form :isEdit="isEdit"
                 @onClose="onClose" @onEdit="updateProduct"></product-form>
</div>

</template>

<script>
import ProductForm from './ProductForm';
export default {
  components: {
    ProductForm
  },
  data() {
    return {
      isEdit: false
    }
  },
  methods: {
    editProduct() {
      this.isEdit = true
      $('#product_form').modal('show')
    },
    onClose () {
      this.isEdit = false
      $('#product_form').modal('hide')
    },
    updateProduct (product) {
      this.$store.commit('currentProduct', product)
      this.onClose()
    }
  },
  computed: {
    product() {
      return this.$store.state.currentProduct
    }
  }
}

</script>
