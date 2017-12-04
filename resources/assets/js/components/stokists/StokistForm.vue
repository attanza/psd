<template src="./stokistForm.html"></template>
<script>
import catchJsonErrors from '../../mixins/catchJsonErrors.js'
import {stokistUrl} from '../../globalConfig.js'
export default {
	data () {
    return {
      id: '',
      area_id: '',
      code: '',
      name: '',
      address: '',
      owner: '',
      pic: '',
      phone1: '',
      phone2: '',
      email: '',
      modalTitle: 'Add stokist'
    }
  },
  props: ['isEdit', 'areas'],
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
            this.editStokist()
          } else {
            this.submitStokist()
          }
          return
        }
      })
    },
    submitStokist () {
      axios.post(stokistUrl, this.getData()).then((resp) => {
        if (resp.status === 201) {
          this.$emit('onAdd', resp.data.data)
          this.handleClose()
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    editStokist () {
      axios.put(stokistUrl + '/' + this.id, this.getData()).then((resp) => {
        if (resp.status === 200) {
          this.$emit('onEdit', resp.data.data)
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    getData () {
      return {
        area_id: this.area_id,
        code: this.code,
        name: this.name,
        owner: this.owner,
        pic: this.pic,
        phone1: this.phone1,
        phone2: this.phone2,
        email: this.email,
        address: this.address,
        lat: -6.2295712,
        lng: 106.759478
      }
    },
    clear () {
      this.dialogTitle = 'Add stokist'
      this.id = ''
      this.area_id = ''
      this.code = ''
      this.name = ''
      this.owner = ''
      this.pic = ''
      this.phone1 = ''
      this.phone2 = ''
      this.email = ''
      this.address = ''
      this.$validator.reset()
    },
    fillForm () {
      if (this.stokist) {
        this.modalTitle = 'Edit stokist'
        this.id = this.stokist.id
        this.area_id = this.stokist.area_id
        this.code = this.stokist.code
        this.name = this.stokist.name
        this.owner = this.stokist.owner
        this.pic = this.stokist.pic
        this.phone1 = this.stokist.phone1
        this.phone2 = this.stokist.phone2
        this.email = this.stokist.email
        this.address = this.stokist.address
      }
    },
    handleClose () {
    	this.clear()
      this.$emit('onClose')
    }
  },
  computed: {
  	stokist () {
  		return this.$store.state.currentStokist
  	}
  },
  mixins: [catchJsonErrors]
}

</script>
