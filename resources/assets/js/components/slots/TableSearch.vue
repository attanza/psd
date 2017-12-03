<template>
<div class="box box-widget">
  <div class="box-body">
    <div class="row">
      <div class="col-sm-4">
        <div class="input-group">
          <span class="input-group-addon">Show</span>
          <select class="form-control"
                  v-model="limit"
                  @change="changePaginate">
            <option v-for="page in perPages"
                    :value="page">{{page}}</option>
          </select>
          <span class="input-group-addon">entries</span>
        </div>
      </div>
      <div class="col-sm-4 col-sm-offset-4 mt-mobile">
        <div class="form-group has-feedback">
          <input class="form-control"
                 placeholder="Search..."
                 v-model="searchQ"
                 @keyup="search"></input>
          <span class="glyphicon glyphicon-search form-control-feedback"></span>
        </div>
      </div>
    </div>
  </div>
</div>

</template>

<script>
export default {
  data() {
    return {
      searchQ: '',
      limit: ''
    }
  },
  props: [
    'perPages',
    'loading',
    'paginate'
  ],
  watch: {
    paginate() {
      if (this.paginate !== null || this.paginate !== '') {
        this.limit = this.paginate
      }
    }
  },
  mounted() {
    this.limit = this.paginate
  },
  methods: {
    search() {
      this.$emit('search', this.searchQ)
    },
    changePaginate() {
      this.$emit('changePaginate', this.limit)
    }
  }
}

</script>
