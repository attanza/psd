<template></template>
<script>
export default {
  props: [
    'user'
  ],
  created() {
    this.$store.commit('user', this.user)
  }
}

</script>
