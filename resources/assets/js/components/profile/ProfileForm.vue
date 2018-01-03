<template src="./profileForm.html"></template>

<script>
import catchJsonErrors from '../../mixins/catchJsonErrors.js';
import { profileUrl } from '../../globalConfig.js';
export default {
  data() {
    return {
      id: '',
      name: '',
      email: ''
    }
  },
  mounted() {
    this.fillForm()
  },
  methods: {
    fillForm() {
      this.id = this.user.id
      this.name = this.user.name
      this.email = this.user.email
    },
    handleClose() {
      this.fillForm()
      $('#profile_form').modal('hide')
    },
    submit() {
      this.$validator.validateAll().then((result) => {
        if (result) {
          this.submitProfile()
          return
        }
      })
    },
    submitProfile() {
      axios.put(profileUrl, this.getData()).then((resp) => {
        if (resp.status === 200) {
          this.$store.commit('user', resp.data.data)
          this.handleClose()
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    getData() {
      return {
        id: this.id,
        name: this.name,
        email: this.email,
      }
    }
  },
  computed: {
    user() {
      return this.$store.state.user
    }
  },
  mixins: [catchJsonErrors]

}

</script>
