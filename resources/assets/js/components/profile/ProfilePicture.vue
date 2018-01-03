<template>
  <img :src="user.photo" class="user-image" :alt="user.name">
</template>
<script>
	export default {
		computed: {
	    user() {
	      return this.$store.state.currentUser
	    }
	  }
	}
</script>