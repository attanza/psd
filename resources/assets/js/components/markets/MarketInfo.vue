<template>
<div class="box box-danger box-solid">
  <div class="box-header with-border">
    <h3 class="box-title">Market Info</h3>
    <div class="box-tools pull-right">
      <button type="button"
              class="btn btn-box-tool"
              @click="editMarket"><i class="fa fa-pencil"></i></button>
    </div>
  </div>
  <div class="box-body">
    <table class="table">
      <tbody>
         <tr>
          <th width="20%">Area</th>
          <td width="80%">{{market.area}}</td>
        </tr>
        <tr>
          <th width="20%">Name</th>
          <td width="80%">{{market.name}}</td>
        </tr>
        <tr>
          <th>Address</th>
          <td>{{market.address}}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <market-form :isEdit="isEdit" :areas="areas"
                 @onClose="onClose" @onEdit="updateMarket"></market-form>
</div>

</template>

<script>
import MarketForm from './MarketForm';
export default {
  components: {
    MarketForm
  },
  data() {
    return {
      isEdit: false
    }
  },
  props: ['areas'],
  methods: {
    editMarket() {
      this.isEdit = true
      $('#market_form').modal('show')
    },
    onClose () {
      this.isEdit = false
      $('#market_form').modal('hide')
    },
    updateMarket (market) {
      this.$store.commit('currentMarket', market)
      this.onClose()
    }
  },
  computed: {
    market() {
      return this.$store.state.currentMarket
    }
  }
}

</script>
