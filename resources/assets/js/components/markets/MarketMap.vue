<template>
<div id="market_map">
  <div class="box box-danger box-solid">
    <div class="box-header with-border">
      <div class="row">
        <div class="col-sm-8">
          <h3 class="box-title">Apartment Map</h3>
        </div>
        <div class="col-sm-4">
          <gmap-autocomplete @place_changed="setPlace"
                           class="m-t-5"></gmap-autocomplete>
        </div>
      </div>
    </div>
    <div class="box-body">
      <div id="location"
           style="width: 100%; height: 40vh;">
        <gmap-map :center="location"
                  :zoom="12"
                  style="width: 100%; height: 40vh;">
          <gmap-marker :position="location"
                       :clickable="true"
                       :draggable="true"
                       @click="center=location"
                       @place_changed="setPlace"
                       @position_changed="markerDrag($event)"></gmap-marker>
        </gmap-map>
      </div>
    </div>
    <div class="box-footer">
      <div class="row">
        <div class="col-md-12">
          <button class="btn btn-danger pull-right"
                  @click="setLocation">
            Save Location
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

</template>

<script>
import catchJsonErrors from '../../mixins/catchJsonErrors.js';
import { marketUrl } from '../../globalConfig.js';
export default {
  data: () => ({
    location: {
      lat: 10.0,
      lng: 10.0,
      location: ''
    },
    markers: [
      {
        position: {
          lat: 10.0,
          lng: 10.0
        }
      }
    ],
    showModal: false,
    snackbar: false,
    snackTime: 5000
  }),
  mounted() {
    this.setInitLoc()
  },
  methods: {
    setPlace(place) {
      this.location = {
        lat: place.geometry.location.lat(),
        lng: place.geometry.location.lng(),
        location: place.formatted_address
      }
    },
    markerDrag(position) {
      this.location = {
        lat: position.lat(),
        lng: position.lng()
      }
    },
    setLocation() {
      axios.put(marketUrl + '/' + this.market.id + '/location', {
        lat: this.location.lat,
        lng: this.location.lng,
        location: this.location.location
      }).then((resp) => {
        if (resp.status === 200) {
          this.$store.commit('currentMarket', resp.data.data)
          this.throw_noty('success', 'Location saved')
        }
      }).catch(error => {
        console.log(error.response)
      })
    },
    setInitLoc: _.debounce(function() {
      if (this.market) {
        this.location.lat = this.market.lat
        this.location.lng = this.market.lng
      }
    }, 1000)
  },
  computed: {
    market() {
      return this.$store.state.currentMarket
    }
  },
  mixins: [
    catchJsonErrors
  ]
}

</script>
<style type="text/css" scoped>
input {
  -moz-appearance: none;
  -webkit-appearance: none;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  border: 1px solid transparent;
  border-radius: 3px;
  -webkit-box-shadow: none;
  box-shadow: none;
  display: -webkit-inline-box;
  display: -ms-inline-flexbox;
  display: inline-flex;
  font-size: 1rem;
  height: 2.25em;
  -webkit-box-pack: start;
  -ms-flex-pack: start;
  justify-content: flex-end;
  line-height: 1.5;
  padding-bottom: calc(0.375em - 1px);
  padding-left: calc(0.625em - 1px);
  padding-right: calc(0.625em - 1px);
  padding-top: calc(0.375em - 1px);
  position: relative;
  vertical-align: top;
  background-color: white;
  border-color: #dbdbdb;
  color: #363636;
  -webkit-box-shadow: inset 0 1px 2px rgba(10, 10, 10, 0.1);
  box-shadow: inset 0 1px 2px rgba(10, 10, 10, 0.1);
  width: 100%;
}
</style>
