<template>
<div class="box box-danger box-solid">
  <div class="box-header with-border">
    <h3 class="box-title">Store Info</h3>
    <div class="box-tools pull-right">
      <button type="button"
              class="btn btn-box-tool"
              @click="editStore"><i class="fa fa-pencil"></i></button>
    </div>
  </div>
  <div class="box-body">
    <table class="table">
      <tbody>
        <tr>
          <th width="30%">Area</th>
          <td width="70%">{{store.area}}</td>
        </tr>
         <tr>
          <th width="30%">Market</th>
          <td width="70%">{{store.market}}</td>
        </tr>
        <tr>
          <th>Code</th>
          <td>{{store.code}}</td>
        </tr>
        <tr>
          <th>Name</th>
          <td>{{store.name}}</td>
        </tr>
        <tr>
          <th>Owner</th>
          <td>{{store.owner}}</td>
        </tr>
        <tr>
          <th>Person in Charge</th>
          <td>{{store.pic}}</td>
        </tr>
        <tr>
          <th>Phone</th>
          <td>{{store.phone1}}</td>
        </tr>
        <tr>
          <th>Other Phone</th>
          <td>{{store.phone2}}</td>
        </tr>
        <tr>
          <th>Email</th>
          <td>{{store.email}}</td>
        </tr>
        <tr>
          <th>Address</th>
          <td>{{store.address}}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <store-form :isEdit="isEdit"
                 @onClose="onClose" @onEdit="updateStore"></store-form>
</div>

</template>

<script>
import StoreForm from './StoreForm';
export default {
  components: {
    StoreForm
  },
  data() {
    return {
      isEdit: false
    }
  },
  props: ['areas'],
  methods: {
    editStore() {
      this.isEdit = true
      $('#store_form').modal('show')
    },
    onClose () {
      this.isEdit = false
      $('#store_form').modal('hide')
    },
    updateStore (store) {
      this.$store.commit('currentStore', store)
      this.onClose()
    }
  },
  computed: {
    store() {
      return this.$store.state.currentStore
    }
  }
}

</script>
