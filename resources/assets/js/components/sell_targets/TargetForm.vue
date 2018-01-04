<template src="./targetForm.html"></template>
<script>
import catchJsonErrors from '../../mixins/catchJsonErrors.js'
import {sellTargetUrl} from '../../globalConfig.js'
import DatePicker from 'vue2-datepicker'
import moment from 'moment'
export default {
  components: { DatePicker },
	data () {
    return {
      id: '', name: '', product_id: '', target_by: '', target_count: '',
      start_date: '', end_date: '', status: 'Open',
      modalTitle: 'Add Target'
    }
  },
  props: ['isEdit', 'products'],
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
            this.edittarget()
          } else {
            this.submitTarget()
          }
          return
        }
      })
    },
    submitTarget () {
      axios.post(sellTargetUrl, this.getData()).then((resp) => {
        if (resp.status === 201) {
          this.$emit('onAdd', resp.data.data)
          this.handleClose()
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    edittarget () {
      axios.put(targetUrl + '/' + this.id, this.getData()).then((resp) => {
        console.log(resp)
        // if (resp.status === 200) {
        //   this.$store.commit('currenttarget', resp.data.data)
        //   this.handleClose()
        // }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    getData () {
      return {
        name: this.name,
        product_id: this.product_id,
        target_by: this.target_by,
        target_count: this.target_count,
        start_date: moment(this.start_date).format("YYYY-MM-DD"),
        end_date: moment(this.end_date).format("YYYY-MM-DD"),
        status: this.status,
      }
    },
    clear () {
      this.dialogTitle = 'Add target'
      this.id = ''
      this.name = ''
      this.product_id = ''
      this.target_by = ''
      this.target_count = ''
      this.start_date = ''
      this.end_date = '',
      this.$validator.reset()
    },
    fillForm () {
      if (this.target) {
        this.modalTitle = 'Edit target'
        this.id = this.target.id
        this.name = this.target.name
        this.email = this.target.email
        this.is_active = this.target.is_active
      }
    },
    handleClose () {
    	this.clear()
      this.$emit('onClose')
    }
  },
  computed: {
  	target () {
  		return this.$store.state.currenttarget
  	}
  },
  mixins: [catchJsonErrors]
}

</script>
