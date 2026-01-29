<template>
  <div :id="id">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'vue-chat-room',
  props: {
    active: { type: Boolean, default: false },
		url: { type: String, default: "" }
  },
  data: function () {
    return {
      id: null,
      loaded: null
    }
  },
  created: function () { this.id = this.$options.name + this._uid },
  mounted: function () { this.load() },
  methods: {
		load: function () {
			this.waiting = true
			let requestData = {
				headers: { 'Accept': 'application/json' },
				method: 'get',
				url: this.url
			}
			axios(requestData)
			.then((response) => {
        console.log(response.data)
				this.loaded = response.data
				this.waiting = false
			}).catch((error) => {
				this.error = error.response
				this.waiting = false
			})
		}
  }
};
</script>