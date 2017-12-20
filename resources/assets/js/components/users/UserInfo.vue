<template>
<div class="box box-danger box-solid">
  <div class="box-header with-border">
    <h3 class="box-title">Outlet Info</h3>
    <div class="box-tools pull-right">
      <button type="button"
              class="btn btn-box-tool"
              @click="editoutlet"><i class="fa fa-pencil"></i></button>
    </div>
  </div>
  <div class="box-body">
    <table class="table">
      <tbody>
        <tr>
          <th width="30%">Area</th>
          <td width="70%">{{outlet.area}}</td>
        </tr>
        <tr>
          <th>Market</th>
          <td>{{outlet.market}}</td>
        </tr>
        <tr>
          <th>Store</th>
          <td>{{outlet.parent}}</td>
        </tr>
        <tr>
          <th>Code</th>
          <td>{{outlet.code}}</td>
        </tr>
        <tr>
          <th>Name</th>
          <td>{{outlet.name}}</td>
        </tr>
        <tr>
          <th>Owner</th>
          <td>{{outlet.owner}}</td>
        </tr>
        <tr>
          <th>Person in Charge</th>
          <td>{{outlet.pic}}</td>
        </tr>
        <tr>
          <th>Phone</th>
          <td>{{outlet.phone1}}</td>
        </tr>
        <tr>
          <th>Other Phone</th>
          <td>{{outlet.phone2}}</td>
        </tr>
        <tr>
          <th>Email</th>
          <td>{{outlet.email}}</td>
        </tr>
        <tr>
          <th>Address</th>
          <td>{{outlet.address}}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <outlet-form :isEdit="isEdit"
                 @onClose="onClose" @onEdit="updateoutlet"></outlet-form>
</div>

</template>

<script>
import OutletForm from './OutletForm';
export default {
  components: {
    OutletForm
  },
  data() {
    return {
      isEdit: false
    }
  },
  props: ['areas'],
  methods: {
    editoutlet() {
      this.isEdit = true
      $('#outlet_form').modal('show')
    },
    onClose () {
      this.isEdit = false
      $('#outlet_form').modal('hide')
    },
    updateoutlet (outlet) {
      this.$store.commit('currentOutlet', outlet)
      this.onClose()
    }
  },
  computed: {
    outlet() {
      return this.$store.state.currentOutlet
    }
  }
}

</script>
