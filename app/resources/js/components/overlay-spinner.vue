<template>
  <transition v-if="active" :id="id" name="vue-overlay-spinner">
    <div class="vue-overlay-spinner-container">
      <div class="vue-overlay-spinner-content">
        <div class="d-flex justify-content-center align-items-center">
          <div v-if="!$slots.spinner_slot" class="spinner-grow m-4" style="height: 5em; width: 5em;" role="status"></div>
          <slot v-else name='spinner_slot'/>
          <slot name='message_slot'/>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: 'vue-overlay-spinner',
  props: { active: { type: Boolean, default: false } },
  data: function () { return { id: null } },
  created: function () { this.id = this.$options.name + this._uid }
};
</script>

<style>
.vue-overlay-spinner-container {
  background-color: rgba(255,255,255,0.75);
  position: fixed; display: block;
  width: 100%; height: 100%;
  top: 0; right: 0; bottom: 0; left: 0;
  z-index: 1080;
}
.vue-overlay-spinner-content {
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%,-50%);
}
.vue-overlay-spinner-enter-active,
.vue-overlay-spinner-leave-active {
  transition: opacity .5s;
}
.vue-overlay-spinner-enter,
.vue-overlay-spinner-leave-to {
  opacity: 0;
}
</style>