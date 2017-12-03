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
      <select class="form-control" v-model="building_id" @change="search">
        <option value="" selected disabled="">Group by Apartment</option>
        <option v-for="building in buildings" :value="building.id">{{building.name}}</option>
      </select>
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
import {buildingForComboUrl} from '../../globalConfig'
import catchJsonErrors from '../../mixins/catchJsonErrors';
export default {
  data() {
    return {
      searchQ: '',
      limit: '',
      buildings: [],
      building_id: ''
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
    this.getBuildings()
  },
  methods: {
    getBuildings () {
      axios.get(buildingForComboUrl).then((resp) => {
        if (resp.status === 200) {
          this.buildings = resp.data
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    search() {
      let data = {
        searchQ: this.searchQ,
        building_id: this.building_id
      }
      this.$emit('search', data)
    },
    changePaginate() {
      this.$emit('changePaginate', this.limit)
    }
  },
  mixins: [catchJsonErrors]
}

</script>
