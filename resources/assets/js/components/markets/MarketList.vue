<template src="./marketList.html"></template>
<script>
import {marketListUrl, areaComboUrl, marketWebUrl} from '../../globalConfig'
import paginationData from '../../mixins/paginationData';
import catchJsonErrors from '../../mixins/catchJsonErrors';
import TableSearch4 from '../slots/TableSearch4';
import TablePagination from '../slots/TablePagination';
import PlusButton from '../slots/PlusButton';
import MarketForm from './MarketForm'
export default {
  components: {
    TableSearch4, TablePagination, PlusButton, MarketForm
  },
  data () {
    return {
      markets: [],
      areas: [],
      areaId: '',
      groupBy: 'Area',
      isEdit: false
    }
  },
  props: [
    'product_type'
  ],
  mounted() {
    this.getAreas()
    this.getMarkets(this.pagination.current_page)
    this.$on('markets', function (markets) {
      this.markets = markets
    })
    this.$on('pagination', function (pagination) {
      this.pagination = pagination
      this.loading = false
    })
    this.$on('areas', function (areas) {
      this.areas = areas
    })
  },
  methods: {
    getAreas () {
      axios.get(areaComboUrl).then((resp) => {
        if (resp.status === 200) {
          this.$emit('areas', resp.data)
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    getMarkets (page) {
      this.loading = true
      axios.post(marketListUrl + '?page=' + page, this.postData()).then((resp) => {
        if (resp.status === 200) {
          this.$emit('markets', resp.data.data)
          this.$emit('pagination', resp.data.meta)
        }
      }).catch((error) => {
        this.catchError(error.response)
      })
    },
    postData () {
      return {
        searchQ: this.searchQ,
        paginate: this.paginate,
        areaId: this.areaId,
      }
    },
    search: _.debounce(function(data) {
      this.searchQ = data.searchQ
      this.areaId = data.comboId
      this.getMarkets(1)
    }, 500),
    changePaginate(p) {
      this.paginate = p
      this.getMarkets(1)
    },
    changePage(p) {
      this.pagination.current_page = p
      this.getMarkets(p)
    },
    prev() {
      this.pagination.current_page = this.pagination.current_page - 1
      this.getMarkets(this.pagination.current_page)
    },
    next() {
      this.pagination.current_page = this.pagination.current_page + 1
      this.getMarkets(this.pagination.current_page)
    },
    addMarket (market) {
      this.markets.unshift(market)
    },
    show (id) {
      window.location.href = marketWebUrl + id
    },
    formClose () {
      this.isEdit = false
      $('#market_form').modal('hide')
      
    }
  },
  mixins: [paginationData, catchJsonErrors]
}

</script>