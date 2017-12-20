<template src="./userForm.html"></template>
<script>
import catchJsonErrors from '../../mixins/catchJsonErrors.js'
import {userUrl} from '../../globalConfig.js'
export default {
	data () {
    return {
      id: '',
      name: '',
      email: '',
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
          this.$emit('onEdit', resp.data.data)
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    getData () {
      return {
        market_id: this.market_id,
        parent_id: this.parent_id,
        reseller_type: 'user',
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
      this.dialogTitle = 'Add user'
      this.id = ''
      this.market_id = ''
      this.parent_id = ''
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
      if (this.user) {
        this.modalTitle = 'Edit user'
        this.id = this.user.id
        this.market_id = this.user.market_id
        this.area_id = this.user.area_id
        this.parent_id = this.user.parent_id
        this.code = this.user.code
        this.name = this.user.name
        this.owner = this.user.owner
        this.pic = this.user.pic
        this.phone1 = this.user.phone1
        this.phone2 = this.user.phone2
        this.email = this.user.email
        this.address = this.user.address
        this.getMarkets()
        this.getParents()
      }
    },
    handleClose () {
    	this.clear()
      this.$emit('onClose')
    }
  },
  computed: {
  	user () {
  		return this.$store.state.currentuser
  	}
  },
  mixins: [catchJsonErrors]
}

</script>
