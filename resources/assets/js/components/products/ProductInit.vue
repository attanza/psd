<template></template>
<script>
export default {
  props: [
    'product'
  ],
  created() {
    this.$store.commit('currentProduct', this.product)
  }
}

</script>
