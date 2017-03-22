<template>
  <transition name="modal">
    <div class="modal-mask" v-show="show">
      <div class="modal-wrapper">
        <div class="modal-container">
          <div class="modal-header" v-if="header">
            <slot name="modal-header">
            </slot>
          </div>
          <div class="modal-body">
            <slot name="modal-body">
            </slot>
          </div>
          <div class="modal-footer">
            <button type="button"
              class="btn btn-primary"
              @click="cancelAction">
                <slot name="modal-cancel"></slot>
            </button>
            <button type="button"
              class="btn btn-primary"
              @click="commitAction">
                <slot name="modal-ok"></slot>
              </button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>

  export default {

    props: {

      show: {
        type: Boolean,
        required: true,
      },
      header: {
        type: Boolean,
        default: false
      },
      event: {
        type: String,
        default: 'commit-action'
      }
    },
    methods: {

      cancelAction: function() {

        this.$emit('cancel-action');
      },
      commitAction: function() {

        this.$emit(this.event);
      }
    }
  }

</script>

<style>

  .modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    background-color: rgba(0, 0, 0, .5);
    width: 100%;
    height: 100%;
    display: table;
    transition: opacity .3s ease;
  }

  .modal-wrapper {
    display: table-cell;
    vertical-align: middle;
  }

  .modal-container {
    width: 300px;
    margin: 0px auto;
    background-color: black;
    opacity: .7;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
    transition: all .3s ease;
  }

  .modal-header {
    margin-top: 0;
    color: #fff;
  }

  .modal-body {
    margin: 10px 0;
    color: #fff
  }

  .modal-default-button {
    float: right;
  }

  .modal-enter, .modal-leave-active {
    opacity: 0;
  }

  .modal-enter .modal-container,
  .modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
  }

</style>