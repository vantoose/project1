export default {
  methods: {
    toFloat: function (v, x=4) { return parseFloat(Number(v).toFixed(x)) },
		isFloat: function (n) { return Number(n) === n && n % 1 !== 0 },
    isEmpty: function (obj) {
      for (let prop in obj) { if (obj.hasOwnProperty(prop)) return false }
      return JSON.stringify(obj) === JSON.stringify({})
    },
    isBlank: function (e) {
      if (e === undefined || e === null || e === '') return true
      if (Array.isArray(e) && e.length === 0) return true
      if (typeof e === 'object') return this.isEmpty(e)
      return false
    },
    go2url: function (url, target) {
      if (target === null || target === undefined) return window.open(url, '_self')
      return window.open(url, target)
    },
		isUrl: function (str) {
			let url
			try { url = new URL(str) } catch (e) { return false }
			return url.protocol === "http:" || url.protocol === "https:"
		}
  }
};