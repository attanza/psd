<template>
<div id="market_photo">
  <div class="box box-widget">
    <div class="box-body">
    <div class="thumbnail">
      <img :src="market.photo">
    </div>
    </div>
    <div class="box-footer">
      <div class="row">
        <div class="col-md-12">
          <button class="btn btn-danger pull-right"
                  @click="showUploader">
            <i class="fa fa-camera"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
  
<div class="modal"
       id="dropzone_uploader">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <dropzone id="myVueDropzone"
                      :url="media.url"
                      v-on:vdropzone-success="showSuccess"
                      :maxFileSizeInMB="media.maxFile"
                      :headers="media.headers"
                      v-on:vdropzone-sending="sending"
                      :use-font-awesome="true"
                      ref="myVueDropzone">
            </dropzone>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</div>

</template>

<script>
import Dropzone from 'vue2-dropzone';
import { mediaUploadUrl } from '../../globalConfig.js';
export default {
  components: {
    Dropzone
  },
  data() {
    return {
      market_id: '',
      media: {
        url: '',
        headers: null,
        maxFile: 5
      }
    }
  },
  created() {
    let token = document.head.querySelector('meta[name="csrf-token"]')
    this.media.url = mediaUploadUrl
    this.media.headers = {
      'X-CSRF-TOKEN': token.content
    }
  },
  mounted() {
    if (this.market) {
      this.market_id = this.market.id
    }
  },
  methods: {
    showSuccess(file, response) {
      this.$store.commit('currentMarket', response.data)
      let vm = this
      vm.$refs.myVueDropzone.removeFile(file)
      $('#dropzone_uploader').modal('hide')
    },
    sending(file, xhr, formData) {
      formData.append('model', 'market')
      formData.append('id', this.market_id)
    },
    showUploader () {
      $('#dropzone_uploader').modal('show')
    }
  },
  computed: {
    market() {
      return this.$store.state.currentMarket
    }
  }
}

</script>

<style type="text/css" scoped>
.image-wrapper {
  min-height: 40vh;
  max-height: 80vh;
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  overflow: hidden;
}
</style>
