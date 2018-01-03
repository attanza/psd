<template>
<div>
  <div class="modal modal-danger " :class="{'is-active' : showDialog}"
       id="modal_dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">
            <i class="fa fa-question-circle fa-3x"></i>
          </h4>
        </div>
        <div class="modal-body">
          <h1 class="text-center">Are you sure ?</h1>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-sm-6">
              <button class="btn btn-outline btn-block"
                      @click="handleClose">
                No
              </button>
            </div>
            <div class="col-sm-6">
              <button class="btn btn-outline btn-block" @click="onConfirm">
                Yes
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</template>

<script>
export default {
  props: ['showDialog'],

  methods: {
    handleClose() {
      this.$emit('closeDialog')
    },
    onConfirm() {
      this.$emit('onConfirm')
    }
  }
}

</script>
<style type="text/css" scoped>
  .is-active {
    display: flex;
    align-items: center;
    justify-content: center;
  }
</style>
