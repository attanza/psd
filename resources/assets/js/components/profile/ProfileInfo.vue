<template>
<div class="box box-danger box-solid">
  <div class="box-header with-border">
    <h3 class="box-title">Profile Info</h3>
    <div class="box-tools pull-right">
      <button type="button"
              class="btn btn-box-tool"
              @click="editProfile"><i class="fa fa-pencil"></i></button>
    </div>
  </div>
  <div class="box-body">
    <table class="table">
      <tbody>
        <tr>
          <td>Name</td>
          <td>{{user.name}}</td>
        </tr>
        <tr>
          <td>Email</td>
          <td>{{user.email}}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <profile-form></profile-form>
</div>

</template>

<script>
import ProfileForm from './ProfileForm';
export default {
  components: {
    // MarketForm
  },
  data() {
    return {
    }
  },
  methods: {
    editProfile() {
      $('#profile_form').modal('show')
    },
    onClose () {
      this.isEdit = false
      $('#market_form').modal('hide')
    },
    updateMarket (market) {
      this.$store.commit('currentMarket', market)
      this.onClose()
    }
  },
  computed: {
    user() {
      return this.$store.state.currentUser
    }
  }
}

</script>
