<template></template>
<script>
export default {
  props: [
    'market'
  ],
  created() {
    this.$store.commit('currentMarket', this.market)
  }
}

</script>
