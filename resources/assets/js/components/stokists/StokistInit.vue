<template></template>
<script>
export default {
  props: [
    'stokist'
  ],
  created() {
    this.$store.commit('currentStokist', this.stokist)
  }
}

</script>
