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
      <div class="col-sm-4 mt-mobile">
         <date-picker v-model="searchDates" range :shortcuts="shortcuts" 
         lang="en"></date-picker>
      </div>
      <div class="col-sm-4 mt-mobile">        
        <div class="input-group">
          <span class="input-group-btn" style="min-width: 100px;">
            <select class="form-control" v-model="sg">
              <option v-for="s in searchGroup" :value="s">{{s}}</option>
            </select>
          </span>
          <input type="text" class="form-control" v-model="searchQ" 
          placeholder="Search for..." @keyup.enter="search">
          <span class="input-group-btn" @click="search">
            <button class="btn btn-default" type="button">
              <i class="fa fa-search"></i>
            </button>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>

</template>

<script>
import moment from 'moment'
import DatePicker from 'vue2-datepicker'
export default {
  components: {
    DatePicker
  },
  data() {
    return {
      searchQ: '',
      limit: '',
      sg: 'Order No',
      shortcuts: [],
      searchDates: [],
    }
  },
  props: [
    'perPages',
    'loading',
    'paginate',
    'searchGroup'
  ],
  watch: {
    paginate() {
      if (this.paginate !== null || this.paginate !== '') {
        this.limit = this.paginate
      }
    },
    searchDates () {
      if (this.searchDates !== null || this.searchDates !== '') {
        this.search()
      }
    }
  },
  created () {
    this.shortcuts = this.getTimeShortCuts()
  },
  mounted() {
    this.limit = this.paginate
  },
  methods: {
    search() {
      let data = {
        searchGroup : this.sg,
        searchQ : this.searchQ,
        searchDates: this.searchDates
      }
      this.$emit('search', data)
    },
    changePaginate() {
      this.$emit('changePaginate', this.limit)
    },
    getTimeShortCuts () {
      let today = moment().format('YYYY-MM-DD HH:mm:ss')
      let firstDayThisMonth = moment().startOf('month').format('YYYY-MM-DD HH:mm:ss')
      let lastDayThisMonth = moment().endOf('month').format('YYYY-MM-DD HH:mm:ss')
      let firstDayLastMonth = moment().subtract(1, 'months').startOf('month').format('YYYY-MM-DD HH:mm:ss')
      let lastDayLastMonth = moment().subtract(1, 'months').endOf('month').format('YYYY-MM-DD HH:mm:ss')
      return [
        {
          text: 'Today',
          start: moment().startOf('day').format('YYYY-MM-DD HH:mm:ss'),
          end: moment().endOf('day').format('YYYY-MM-DD HH:mm:ss')
        },
        {
          text: 'Last 7 days',
          start: moment().add(-7, 'days').format('YYYY-MM-DD HH:mm:ss'),
          end: today
        },
        {
          text: 'Last 30 days',
          start: moment().add(-30, 'days').format('YYYY-MM-DD HH:mm:ss'),
          end: today
        },
        {
          text: 'This month',
          start: firstDayThisMonth,
          end: lastDayThisMonth
        },
        {
          text: 'Last month',
          start: firstDayLastMonth,
          end: lastDayLastMonth
        }
      ]
    }
  }
}

</script>
