<template src="./userForm.html"></template>
<script>
import catchJsonErrors from '../../mixins/catchJsonErrors.js'
import {userUrl} from '../../globalConfig.js'
import Switches from 'vue-switches'
export default {
  components: { Switches },
	data () {
    return {
      id: '',
      name: '',
      email: '',
      phone: '',
      is_active: false,
      modalTitle: 'Add user'
    }
  },
  props: ['isEdit'],
  watch: {
  	isEdit () {
  		if (this.isEdit) {
  			this.fillForm()
  		}
  	}
  },
  methods: {
    submit() {
      this.$validator.validateAll().then((result) => {
        if (result) {
          if (this.isEdit) {
            this.edituser()
          } else {
            this.submitUser()
          }
          return
        }
      })
    },
    submitUser () {
      axios.post(userUrl, this.getData()).then((resp) => {
        if (resp.status === 201) {
          this.$emit('onAdd', resp.data.data)
          this.handleClose()
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    edituser () {
      axios.put(userUrl + '/' + this.id, this.getData()).then((resp) => {
        if (resp.status === 200) {
          let msg = 'A temporary password has been sent to ' + resp.data.data.email
          this.$store.commit('currentUser', resp.data.data)
          this.throw_noty('success', msg)
          this.handleClose()
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    getData () {
      return {
        name: this.name,
        email: this.email,
        phone: this.phone,
        is_active: this.is_active,
      }
    },
    clear () {
      this.dialogTitle = 'Add user'
      this.id = ''
      this.name = ''
      this.email = ''
      this.phone = ''
      this.is_active = ''
      this.$validator.reset()
    },
    fillForm () {
      if (this.user) {
        this.modalTitle = 'Edit user'
        this.id = this.user.id
        this.name = this.user.name
        this.email = this.user.email
        this.phone = this.user.phone
        this.is_active = this.user.is_active
      }
    },
    handleClose () {
    	this.clear()
      this.$emit('onClose')
    }
  },
  computed: {
  	user () {
  		return this.$store.state.currentUser
  	}
  },
  mixins: [catchJsonErrors]
}

</script>
