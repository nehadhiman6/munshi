<template>
  <input v-model="val" @input="updateValue($event.target.value)" />
</template>

<script>
export default {
  props: {
    value: {
      required: true,
      type: [Number, String]
    },
    // Using for: String.prototype.replace(regexp, replacement)
    regExp: {
      type: RegExp,
      default: null
    },
    // Using for: String.prototype.replace(regexp, replacement)
    replacement: {
      type: String,
      default: ''
    }
  },
  emits: ['update:value'],
  data () {
    return {
      val: ''
    }
  },
  methods: {
    // format the value of input
    formatValue (val) {
      const formattedValue = val.toString().replace(this.regExp, this.replacement)
      return formattedValue
    },
    // update the value of input
    updateValue (val) {
      const formattedValue = this.formatValue(val)
      this.val = formattedValue
      this.emitInput(formattedValue)
    },
    // emit input event
    emitInput (val) {
         this.$emit('input', val)
    }
  },
  watch: {
    // watch value prop
    value: {
      handler (val = '') {
        if (val !== this.val) {
          this.updateValue(val)
        }
      },
      immediate: true
    }
  }
}
</script>
