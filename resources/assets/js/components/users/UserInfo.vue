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
          <td>Active Status</td>
          <td>
            <span v-if="user.is_active"><i class="fa fa-check"></i></span>
            <span v-else><i class="fa fa-times"></i></span>
          </td>
        </tr>
        <tr>
          <td>Last Login</td>
          <td>
            <span v-if="user.last_login !== null">{{getRealtiveTime(user.last_login)}}</span>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <button type="button" class="btn btn-block btn-danger btn-sm" @click="showDialog = true">Reset Password</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <!-- <user-form></user-form> -->
  <!-- <change-password></change-password> -->
  <modal-dialog :showDialog="showDialog" @closeDialog="showDialog = false" @onConfirm="resetPassword"></modal-dialog>
</div>

</template>

<script>
import UserForm from './UserForm';
import moment from 'moment';
import {resetPasswordUrl} from '../../globalConfig'
import catchJsonErrors from '../../mixins/catchJsonErrors.js'
import ModalDialog from '../common/ModalDialog';

export default {
  components: {
    UserForm, ModalDialog
  },
  data() {
    return {
      showDialog: false
    }
  },
  methods: {
    editProfile() {
      $('#profile_form').modal('show')
    },
    resetPassword() {
      this.showDialog = false
      axios.get(resetPasswordUrl+this.user.id).then((resp) => {
        console.log(resp)
        if (resp.status === 200) {
          this.throw_noty('success', resp.data.msg)
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    getRealtiveTime(t) {
      return moment(t).fromNow()
    }
  },
  computed: {
    user() {
      return this.$store.state.currentUser
    }
  },
  mixins: [catchJsonErrors]

}

</script>
