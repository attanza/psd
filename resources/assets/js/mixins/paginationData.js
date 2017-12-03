export default {
  data() {
    return {
      searchQ: '',
      paginate: 10,
      pagination: {
        total: 0,
        per_page: 0,
        from: 1,
        to: 0,
        current_page: 1
      },
      links: {},
      perPages: [10, 25, 50],
      loading: false,
    }
  },
  methods: {
    str_limit(str, limit) {
      if (str.length >= limit) {
        return str.substr(0, limit) + '...'
      } else {
        return str
      }
    }
  }
}
