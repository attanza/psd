<template src="./roleForm.html"></template>
<script>
import catchJsonErrors from '../../mixins/catchJsonErrors.js'
import {roleUrl} from '../../globalConfig.js'
export default {
	data () {
    return {
      id: '',
      name: '',
      display_name: '',
      description: '',
      modalTitle: 'Add role'
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
            this.editRole()
          } else {
            this.submitRole()
          }
          return
        }
      })
    },
    submitRole () {
      axios.post(roleUrl, this.getData()).then((resp) => {
        console.log(resp)
        if (resp.status === 201) {
          this.$emit('onAdd', resp.data.data)
          this.handleClose()
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    editRole () {
      axios.put(roleUrl + '/' + this.id, this.getData()).then((resp) => {
        if (resp.status === 200) {
          this.$emit('onEdit', resp.data.data)
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    getData () {
      return {
        name: this.name,
        display_name: this.display_name,
        description: this.description
      }
    },
    clear () {
      this.dialogTitle = 'Add role'
      this.name = ''
      this.display_name = ''
      this.description = ''
      this.$validator.reset()
    },
    fillForm () {
      if (this.role) {
        this.modalTitle = 'Edit role'
        this.id = this.role.id
        this.name = this.role.name
        this.display_name = this.role.display_name
        this.description = this.role.description
      }
    },
    handleClose () {
    	this.clear()
      this.$emit('onClose')
    }
  },
  computed: {
  	role () {
  		return this.$store.state.currentRole
  	}
  },
  mixins: [catchJsonErrors]
}

</script>
