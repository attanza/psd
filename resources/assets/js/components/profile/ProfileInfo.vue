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
        <tr>
          <td colspan="2">
            <button type="button" class="btn btn-block btn-warning btn-sm" @click="handleChangePassword">Change Password</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <profile-form></profile-form>
  <change-password></change-password>
</div>

</template>

<script>
import ProfileForm from './ProfileForm';
import ChangePassword from './ChangePassword';

export default {
  components: {
    ProfileForm, ChangePassword
  },
  data() {
    return {
    }
  },
  methods: {
    editProfile() {
      $('#profile_form').modal('show')
    },
    handleChangePassword() {
      $('#changePassword').modal('show')
    }
  },
  computed: {
    user() {
      return this.$store.state.user
    }
  }
}

</script>
