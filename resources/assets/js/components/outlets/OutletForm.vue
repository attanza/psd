<template src="./outletForm.html"></template>
<script>
import catchJsonErrors from '../../mixins/catchJsonErrors.js'
import {outletUrl, areaComboUrl, marketByAreaUrl, storeComboUrl} from '../../globalConfig.js'
export default {
	data () {
    return {
      id: '',
      areas: [],
      area_id: '',
      markets: [],
      market_id: '',
      parents: [],
      parent_id: '',
      code: '',
      name: '',
      address: '',
      owner: '',
      pic: '',
      phone1: '',
      phone2: '',
      email: '',
      modalTitle: 'Add outlet'
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
  mounted () {
    this.getAreas()
    this.$on('areas', function (areas) {
      this.areas = areas
    })
  },
  methods: {
    getAreas () {
      axios.get(areaComboUrl).then((resp) => {
        if (resp.status === 200) {
          this.$emit('areas', resp.data)
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    getMarkets () {
      axios.get(marketByAreaUrl + this.area_id).then((resp) => {
        if (resp.status === 200) {
          this.markets = resp.data
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    getParents () {
      axios.get(storeComboUrl + '/' + this.market_id).then((resp) => {
        if (resp.status === 200) {
          this.parents = resp.data
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    submit() {
      this.$validator.validateAll().then((result) => {
        if (result) {
          if (this.isEdit) {
            this.editoutlet()
          } else {
            this.submitOutlet()
          }
          return
        }
      })
    },
    submitOutlet () {
      console.log('submit')
      axios.post(outletUrl, this.getData()).then((resp) => {
        if (resp.status === 201) {
          this.$emit('onAdd', resp.data.data)
          this.handleClose()
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    editoutlet () {
      axios.put(outletUrl + '/' + this.id, this.getData()).then((resp) => {
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
        reseller_type: 'Outlet',
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
      this.dialogTitle = 'Add outlet'
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
      if (this.outlet) {
        this.modalTitle = 'Edit outlet'
        this.id = this.outlet.id
        this.market_id = this.outlet.market_id
        this.area_id = this.outlet.area_id
        this.parent_id = this.outlet.parent_id
        this.code = this.outlet.code
        this.name = this.outlet.name
        this.owner = this.outlet.owner
        this.pic = this.outlet.pic
        this.phone1 = this.outlet.phone1
        this.phone2 = this.outlet.phone2
        this.email = this.outlet.email
        this.address = this.outlet.address
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
  	outlet () {
  		return this.$store.state.currentOutlet
  	}
  },
  mixins: [catchJsonErrors]
}

</script>
