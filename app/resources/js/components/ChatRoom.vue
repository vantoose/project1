<template>
  <div :id="id">
    <vue-overlay-spinner :active="waiting"/>
    <div v-show="!waiting" class="card">
      <template v-if="room">
        <div class="card-header">
          <span class="mr-2" style="cursor: pointer;" title="Back to rooms" @click.prevent="room = null"><i class="fa-solid fa-chevron-left"></i></span>
          <span>{{ room.name }}</span>
        </div>
      </template>
      <template v-if="room">
          <div class="card-body">
            <template v-if="messages">
              <dl class="row">
                <template v-for="(value, key) in messages" v-key="key">
                  <dt class="col-sm-2 text-sm-right">{{ value.username }}</dt>
                  <dd class="col-sm-8">{{ value.message }}</dd>
                  <dd class="col-sm-2">
                    <span class="form-text text-muted small">{{ value.datetime }}</span>
                  </dd>
                </template>
              </dl>
            </template>
            <button type="button" class="btn btn-link btn-block mb-2" @click.prevent="loadMessages(room.id)">
              <i class="fa-solid fa-arrows-rotate"></i>
              <span>Refresh</span>
            </button>
            <form>
              <div class="form-group">
                <textarea v-model="message" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div>
              <button type="button" class="btn btn-primary" @click.prevent="sendMessage(room.id)">Submit</button>
            </form>
          </div>
      </template>
      <template v-else>
        <div class="list-group list-group-flush">
          <template v-for="(value, key) in rooms" v-key="key">
            <button type="button" class="list-group-item list-group-item-action" @click.prevent="selectRoom(key)">
              <div>{{ value.name }}</div>
              <div class="text-muted small">{{ value.description }}</div>
            </button>
          </template>
        </div>
      </template>
      <template v-if="room">
        <div class="card-footer">
          <span class="text-muted">{{ room.description }}</span>
        </div>
      </template>
    </div>
  </div>
</template>

<script>
import OvarlaySpinner from './OverlaySpinner.vue';
export default {
  components: {  OvarlaySpinner },
  name: 'vue-chat-room',
  props: {
		url: { type: String, default: "" }
  },
  data: function () {
    return {
      id: null,
      messages: [],
      message: '',
      rooms: [],
      room: null,
      waiting: false
    }
  },
  watch: {
    room: {
      deep: false,
      immediate: false,
      handler: function (val, oldVal) {
        if (val) {
          this.loadMessages(val.id)
        } else {
          this.messages = []
        }
      }
    }
  },
  created: function () { this.id = this.$options.name + this._uid },
  mounted: function () { this.loadRooms() },
  methods: {
    selectRoom: function (key) { this.room = this.rooms[key] },
		sendMessage: function (room_id) {
			this.waiting = true
			let requestData = {
				headers: { 'Accept': 'application/json' },
				method: 'post',
				url: this.url + '/room/' + room_id + '/message',
        data: {
          message: this.message,
        },
			}
			axios(requestData)
			.then((response) => {
        this.loadMessages(room_id)
        this.message = ''
				this.waiting = false
			}).catch((error) => {
				this.error = error.response
				this.waiting = false
			})
		},
		loadMessages: function (room_id) {
			this.waiting = true
			let requestData = {
				headers: { 'Accept': 'application/json' },
				method: 'get',
				url: this.url + '/room/' + room_id + '/messages'
			}
			axios(requestData)
			.then((response) => {
				this.messages = response.data.messages
				this.waiting = false
			}).catch((error) => {
				this.error = error.response
				this.waiting = false
			})
		},
		loadRooms: function () {
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