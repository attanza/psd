<template src="./storeForm.html"></template>
<script>
import catchJsonErrors from '../../mixins/catchJsonErrors.js'
import {storeUrl, areaComboUrl, marketByAreaUrl} from '../../globalConfig.js'
export default {
	data () {
    return {
      id: '',
      areas: [],
      area_id: '',
      markets: [],
      market_id: '',
      code: '',
      name: '',
      address: '',
      owner: '',
      pic: '',
      phone1: '',
      phone2: '',
      email: '',
      modalTitle: 'Add store'
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
    submit() {
      this.$validator.validateAll().then((result) => {
        if (result) {
          if (this.isEdit) {
            this.editstore()
          } else {
            this.submitStore()
          }
          return
        }
      })
    },
    submitStore () {
      axios.post(storeUrl, this.getData()).then((resp) => {
        if (resp.status === 201) {
          this.$emit('onAdd', resp.data.data)
          this.handleClose()
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    editstore () {
      axios.put(storeUrl + '/' + this.id, this.getData()).then((resp) => {
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
        parent_id: 0,
        reseller_type: 'Store',
        code: this.code,
        name: this.name,
        owner: this.owner,
        pic: this.pic,
        phone1: this.phone1,
        phone2: this.phone2,
        email: this.email,
        address: this.address,
        lat: -6.2295712,
        lng: 106.759478,
        parent_id: 0
      }
    },
    clear () {
      this.dialogTitle = 'Add store'
      this.id = ''
      this.market_id = ''
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
      if (this.store) {
        this.modalTitle = 'Edit store'
        this.id = this.store.id
        this.market_id = this.store.market_id
        this.area_id = this.store.area_id
        this.code = this.store.code
        this.name = this.store.name
        this.owner = this.store.owner
        this.pic = this.store.pic
        this.phone1 = this.store.phone1
        this.phone2 = this.store.phone2
        this.email = this.store.email
        this.address = this.store.address
        this.getMarkets()
      }
    },
    handleClose () {
    	this.clear()
      this.$emit('onClose')
    }
  },
  computed: {
  	store () {
  		return this.$store.state.currentStore
  	}
  },
  mixins: [catchJsonErrors]
}

</script>
