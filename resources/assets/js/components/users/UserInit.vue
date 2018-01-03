<template></template>
<script>
export default {
  props: [
    'user'
  ],
  created() {
    this.$store.commit('currentUser', this.user)
  }
}

</script>
