<template src="./marketForm.html"></template>
<script>
import catchJsonErrors from '../../mixins/catchJsonErrors.js'
import {marketUrl} from '../../globalConfig.js'
export default {
	data () {
    return {
      id: '',
      area_id: '',
      name: '',
      address: '',
      modalTitle: 'Add Market'
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
            this.editMarket()
          } else {
            this.submitMarket()
          }
          return
        }
      })
    },
    submitMarket () {
      axios.post(marketUrl, this.getData()).then((resp) => {
        console.log(resp)
        if (resp.status === 201) {
          this.$emit('onAdd', resp.data.data)
          this.handleClose()
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    editMarket () {
      axios.put(marketUrl + '/' + this.id, this.getData()).then((resp) => {
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
        name: this.name,
        description: this.description,
        lat: -6.2295712,
        lng: 106.759478
      }
    },
    clear () {
      this.dialogTitle = 'Add Market'
      this.id = ''
      this.area_id = ''
      this.name = ''
      this.address = ''
      this.$validator.reset()
    },
    fillForm () {
      if (this.market) {
        this.modalTitle = 'Edit Market'
        this.id = this.market.id
        this.area_id = this.market.area_id
        this.name = this.market.name
        this.address = this.market.address
      }
    },
    handleClose () {
    	this.clear()
      this.$emit('onClose')
    }
  },
  computed: {
  	market () {
  		return this.$store.state.currentMarket
  	}
  },
  mixins: [catchJsonErrors]
}

</script>
