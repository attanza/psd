<template>
<div>
  <button type="button"
          class="btn-float"
          data-toggle="modal"
          :data-target="dataTarget">
    <i class="fa fa-plus"></i>
  </button>
</div>

</template>

<script>
export default {
  data() {
    return {
      dataTarget: ''
    }
  },
  props: [
    'target'
  ],
  mounted() {
    this.dataTarget = '#' + this.target
  }
}

</script>
