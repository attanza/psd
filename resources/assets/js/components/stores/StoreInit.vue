<template></template>
<script>
export default {
  props: [
    'store'
  ],
  created() {
    this.$store.commit('currentStore', this.store)
  }
}

</script>
