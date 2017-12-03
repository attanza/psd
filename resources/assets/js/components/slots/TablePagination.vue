<template>
<div class="box box-widget">
  <div class="box-footer">
    <div class="row">
      <div class="col-sm-4">
        <p class="custom-p">
          Showing {{pagination.from}} to {{pagination.to}} of {{pagination.total}}
        </p>
      </div>
      <div class="col-sm-8 ">
        <div class="btn-group"
             role="group"
             aria-label="...">
          <div class="btn-group"
               role="group">
            <div class="dropup">
              <button type="button"
                      class="btn btn-default dropdown-toggle"
                      data-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false">
                {{pagination.current_page}}
                <span class="caret m-l-10"></span>
              </button>
              <ul class="dropdown-menu">
                <li v-for="page in pagination.last_page">
                  <a href="javascript:void(0)"
                     @click="changePage(page)">{{page}}</a>
                </li>
              </ul>
            </div>
          </div>
          <button type="button"
                  class="btn btn-default"
                  @click="prev">
            <i class="fa fa-chevron-left"></i>
          </button>
          <button type="button"
                  class="btn btn-default"
                  @click="next">
            <i class="fa fa-chevron-right"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

</template>

<script>
export default {
  props: [
    'pagination'
  ],
  methods: {
    changePage(p) {
      this.$emit('changePage', p)
    },
    prev() {
      if (this.pagination.current_page === 1) {
        return
      } else {
        this.$emit('prev')
      }
    },
    next() {
      if (this.pagination.current_page === this.pagination.last_page) {
        return
      } else {
        this.$emit('next')
      }
    }
  }
}

</script>
