<template>
  <div :id="id">
    <div class="card">
      <template v-if="room">
      <div class="card-header">{{ room.name }}</div>
      </template>
      <template v-if="!room">
        <div class="list-group list-group-flush">
          <template v-for="(value, key) in rooms" v-key="key">
            <button type="button" class="list-group-item list-group-item-action" @click.prevent="selectRoom(key)">
              <div>{{ value.name }}</div>
              <div class="form-text text-muted small">{{ value.description }}</div>
            </button>
          </template>
        </div>
      </template>
      <template v-if="room">
        <div class="card-body">
          <dl class="row">
            <template v-for="(value, key) in room.messages" v-key="key">
              <dt class="col-sm-3">{{ value.user_id }}</dt>
              <dd class="col-sm-9">{{ value.message }}</dd>
            </template>
          </dl>
        </div>
      </template>
      <template v-if="room">
        <div class="card-footer" style="cursor: pointer;" @click="room = null">Back to rooms</div>
      </template>
    </div>
  </div>
</template>

<script>
export default {
  name: 'vue-chat-room',
  props: {
		url: { type: String, default: "" }
  },
  data: function () {
    return {
      id: null,
      rooms: null,
      room: null,
    }
  },
  created: function () { this.id = this.$options.name + this._uid },
  mounted: function () { this.load() },
  methods: {
    selectRoom: function (key) { this.room = this.rooms[key] },
		load: function () {
			this.waiting = true
			let requestData = {
				headers: { 'Accept': 'application/json' },
				method: 'get',
				url: this.url
			}
			axios(requestData)
			.then((response) => {
				this.rooms = response.data.rooms
				this.waiting = false
			}).catch((error) => {
				this.error = error.response
				this.waiting = false
			})
		}
  }
};
</script>