<template src="./areaForm.html"></template>
<script>
import catchJsonErrors from '../../mixins/catchJsonErrors.js'
import {areaUrl} from '../../globalConfig.js'
export default {
	data () {
    return {
      id: '',
      name: '',
      description: '',
      modalTitle: 'Add Area'
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
            this.editProduct()
          } else {
            this.submitArea()
          }
          return
        }
      })
    },
    submitArea () {
      axios.post(areaUrl, this.getData()).then((resp) => {
        console.log(resp)
        if (resp.status === 201) {
          this.$emit('onAdd', resp.data.data)
          this.handleClose()
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    editProduct () {
      axios.put(areaUrl + '/' + this.id, this.getData()).then((resp) => {
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
        description: this.description
      }
    },
    clear () {
      this.dialogTitle = 'Add Area'
      this.name = ''
      this.description = ''
      this.$validator.reset()
    },
    fillForm () {
      if (this.area) {
        this.modalTitle = 'Edit Area'
        this.id = this.area.id
        this.name = this.area.name
        this.description = this.area.description
      }
    },
    handleClose () {
    	this.clear()
      this.$emit('onClose')
    }
  },
  computed: {
  	area () {
  		return this.$store.state.currentArea
  	}
  },
  mixins: [catchJsonErrors]
}

</script>
