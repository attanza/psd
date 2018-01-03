
<template src="./changePassword.html"></template>

<script>
import catchJsonErrors from '../../mixins/catchJsonErrors.js';
import { profileUrl } from '../../globalConfig.js';
export default {
  data() {
    return {
      old_password: '',
      password: '',
      password_confirmation: ''
    }
  },
  methods: {
    handleClose() {
      this.old_password = ''
      this.password = ''
      this.password_confirmation = ''
      $('#changePassword').modal('hide')
      this.$validator.reset()

    },
    submit() {
      this.$validator.validateAll().then((result) => {
        if (result) {
          this.submitChangePassword()
          return
        }
      })
    },
    submitChangePassword() {
      axios.post(profileUrl + '/change-password', this.getData()).then((resp) => {
        if (resp.status === 200) {
          this.handleClose()
          this.throw_noty('success', 'Password updated')
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    getData() {
      return {
        old_password: this.old_password,
        password: this.password,
        password_confirmation: this.password_confirmation,
      }
    }
  },

  mixins: [catchJsonErrors]

}

</script>
