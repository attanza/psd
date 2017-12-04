<template>
<div class="box box-danger box-solid">
  <div class="box-header with-border">
    <h3 class="box-title">Stokist Info</h3>
    <div class="box-tools pull-right">
      <button type="button"
              class="btn btn-box-tool"
              @click="editStokist"><i class="fa fa-pencil"></i></button>
    </div>
  </div>
  <div class="box-body">
    <table class="table">
      <tbody>
         <tr>
          <th width="30%">Area</th>
          <td width="70%">{{stokist.area}}</td>
        </tr>
        <tr>
          <th>Code</th>
          <td>{{stokist.code}}</td>
        </tr>
        <tr>
          <th>Name</th>
          <td>{{stokist.name}}</td>
        </tr>
        <tr>
          <th>Owner</th>
          <td>{{stokist.owner}}</td>
        </tr>
        <tr>
          <th>Person in Charge</th>
          <td>{{stokist.pic}}</td>
        </tr>
        <tr>
          <th>Phone</th>
          <td>{{stokist.phone1}}</td>
        </tr>
        <tr>
          <th>Other Phone</th>
          <td>{{stokist.phone2}}</td>
        </tr>
        <tr>
          <th>Email</th>
          <td>{{stokist.email}}</td>
        </tr>
        <tr>
          <th>Address</th>
          <td>{{stokist.address}}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <stokist-form :isEdit="isEdit" :areas="areas"
                 @onClose="onClose" @onEdit="updateStokist"></stokist-form>
</div>

</template>

<script>
import StokistForm from './StokistForm';
export default {
  components: {
    StokistForm
  },
  data() {
    return {
      isEdit: false
    }
  },
  props: ['areas'],
  methods: {
    editStokist() {
      this.isEdit = true
      $('#stokist_form').modal('show')
    },
    onClose () {
      this.isEdit = false
      $('#stokist_form').modal('hide')
    },
    updateStokist (stokist) {
      this.$store.commit('currentStokist', stokist)
      this.onClose()
    }
  },
  computed: {
    stokist() {
      return this.$store.state.currentStokist
    }
  }
}

</script>
