<template>
  <div :id="id">
    <vue-overlay-spinner :active="waiting"/>

    <div class="card-body">
      <template v-if="messages">
        <template v-for="(value, key) in chat" v-key="key">
          <div class="text-center text-muted small">{{ key }}</div>
          <dl class="row">
            <template v-for="(v, k) in value" v-key="k">
              <dt class="col-sm-3 text-sm-right">
                <div>{{ v.username }}</div>
                <div class="text-muted small">{{ v.time }}</div>
              </dt>
              <dd class="col-sm-9">{{ v.message }}</dd>
            </template>
          </dl>
        </template>
      </template>
      <button type="button" class="btn btn-link btn-block text-decoration-none mb-2" :disabled="loading || waiting" @click.prevent="load(_room.id)">
        <i class="fa-solid fa-arrows-rotate" :class="loading ? 'fa-spin' : '' "></i>
        <span>Refresh</span>
      </button>
      <form>
        <div class="form-group">
          <textarea v-model="message" class="form-control" rows="3" :readonly="waiting"></textarea>
        </div>
        <button type="button" class="btn btn-primary" :disabled="!message || waiting" @click.prevent="send(_room.id)">Submit</button>
      </form>
    </div>

  </div>
</template>

<script>
import OvarlaySpinner from './OverlaySpinner.vue';
export default {
  components: {  OvarlaySpinner },
  name: 'vue-chat-room',
  props: {
    _room: { type: Object, default: () => { return {} } },
		_loadUrl: { type: String, default: "" },
		_sendUrl: { type: String, default: "" },
  },
  data: function () {
    return {
      id: null,
      messages: [],
      message: '',
      loading: false,
      waiting: false
    }
  },
	computed: {
		chat: function () {
			return _.groupBy(this.messages, 'date')
		},
  },
  created: function () { this.id = this.$options.name + this._uid },
  mounted: function () { this.messages = this._room.messages },
  methods: {
		send: function (room_id) {
			this.waiting = true
			let requestData = {
				headers: { 'Accept': 'application/json' },
				method: 'post',
				url: this._sendUrl,
        data: {
          message: this.message,
        },
			}
			axios(requestData)
			.then((response) => {
        this.load(room_id)
        this.message = ''
				this.waiting = false
			}).catch((error) => {
				this.error = error.response
				this.waiting = false
			})
		},
		load: function (room_id) {
			this.loading = true
			let requestData = {
				headers: { 'Accept': 'application/json' },
				method: 'get',
				url: this._loadUrl
			}
			axios(requestData)
			.then((response) => {
        console.log(response.data.messages)
				this.messages = response.data.messages
				this.loading = false
			}).catch((error) => {
				this.error = error.response
				this.loading = false
			})
		},
  }
};
</script>