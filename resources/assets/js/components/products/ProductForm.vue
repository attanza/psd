<template src="./productForm.html"></template>
<script>
import catchJsonErrors from '../../mixins/catchJsonErrors.js'
import {productUrl} from '../../globalConfig.js'
export default {
	data () {
    return {
      id: '',
      code: '',
      name: '',
      measurement: '',
      price: '',
      modalTitle: 'Add Product'
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
            this.submitProduct()
          }
          return
        }
      })
    },
    submitProduct () {
      axios.post(productUrl, this.getData()).then((resp) => {
        if (resp.status === 201) {
          this.$emit('onAdd', resp.data)
          this.handleClose()
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    editProduct () {
      axios.put(productUrl + '/' + this.id, this.getData()).then((resp) => {
        if (resp.status === 200) {
          this.$emit('onEdit', resp.data.data)
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    getData () {
      return {
        code: this.code,
        name: this.name,
        measurement: this.measurement,
        price: this.price,
      }
    },
    clear () {
      this.dialogTitle = 'Add Product'
      this.code = ''
      this.name = ''
      this.measurement = ''
      this.price = ''
      this.$validator.reset()
    },
    fillForm () {
      if (this.product) {
        this.modalTitle = 'Edit Product'
        this.id = this.product.id
        this.code = this.product.code
        this.name = this.product.name
        this.measurement = this.product.measurement
        this.price = this.product.price
      }
    },
    handleClose () {
    	this.clear()
      this.$emit('onClose')
      $('#product_form').modal('hide')
    }
  },
  computed: {
  	product () {
  		return this.$store.state.currentProduct
  	}
  },
  mixins: [catchJsonErrors]
}

</script>
