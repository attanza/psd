<template></template>
<script>
export default {
  props: [
    'outlet'
  ],
  created() {
    this.$store.commit('currentOutlet', this.outlet)
  }
}

</script>
