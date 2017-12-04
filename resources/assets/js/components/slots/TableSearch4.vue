<template>
<div id="table-search3" style="margin-bottom: 20px;">
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
    <div class="col-sm-4 mt-mobile">
      
      <div class="input-group">
        <select class="form-control" v-model="comboId" @change="search">
          <option value="" selected disabled="">Group by {{groupBy}}</option>
          <option v-for="data in comboData" :value="data.id">{{data.name}}</option>
        </select>
        <span class="input-group-btn">
          <button class="btn btn-default" type="button" @click="clearSelect">
            <i class="fa fa-times"></i>
          </button>
        </span>
      </div>
    </div>
    <div class="col-sm-4 mt-mobile">
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

</template>

<script>
import catchJsonErrors from '../../mixins/catchJsonErrors';
export default {
  data() {
    return {
      searchQ: '',
      limit: '',
      comboId: ''
    }
  },
  props: [
    'perPages',
    'loading',
    'paginate',
    'comboData',
    'groupBy'
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
      let data = {
        searchQ: this.searchQ,
        comboId: this.comboId
      }
      this.$emit('search', data)
    },
    changePaginate() {
      this.$emit('changePaginate', this.limit)
    },
    clearSelect () {
      this.comboId = ''
      this.search()
    }
  },
  mixins: [catchJsonErrors]
}

</script>
