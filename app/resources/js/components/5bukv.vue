<template>
	<div :id="id">
		<div v-if="error" class="alert alert-danger" role="alert">
			<div v-if="error.statusText">
				<span class="text-muted">Status:</span>
				<span v-if="error.status">{{ error.status }}.</span>
				<span>{{ error.statusText }}.</span>
			</div>
			<div v-if="error.data && error.data.message">
				<span class="text-muted">Message:</span>
				{{ error.data.message }}.
			</div>
		</div>
		<template v-else>

			<div class="card">
				<div class="card-body">
					<div class="mb-2">
						<template v-for="(letter, key) in primer" v-key="key">
							<button type="button" class="btn mr-1 mb-1" :class="button_class(letter)" @click.prevent="btn_clck(letter)">{{ letter }}</button>
						</template>
					</div>
					<dl class="row mb-0">
						<template v-if="exclude.length > 0">
							<dt class="col-sm-4">Не содержит:</dt>
							<dd class="col-sm-8">
								<template v-for="(letter, key) in exclude" v-key="key">
									<span class="badge badge-secondary mr-1 mb-1">{{ letter }}</span>
								</template>
							</dd>
						</template>
						<template v-if="include.length > 0">
							<dt class="col-sm-4">Содержит:</dt>
							<dd class="col-sm-8">
								<template v-for="(letter, key) in include" v-key="key">
									<span class="badge badge-primary mr-1 mb-1">{{ letter }}</span>
								</template>
							</dd>
							<dt class="col-sm-4">Последовательность:</dt>
							<dd class="col-sm-8">
								<div class="d-flex flex-row">
									<template v-for="(value, key) in subsequence" v-key="key">
										<select v-model="subsequence[key]" class="custom-select mr-1 mb-1">
											<option :value="null">?</option>
											<template v-for="(letter, k) in include" v-key="k">
												<option :value="letter">{{ letter }}</option>
											</template>
										</select>
									</template>
								</div>
							</dd>
						</template>
						<template v-if="filtered_dictionary.length && letter_rating.length">
							<dt class="col-sm-4">Рейтинг букв:</dt>
							<dd class="col-sm-8">
								<div class="d-flex justify-content-around">
									<template v-for="(value, key) in letter_rating" v-key="key">
										<div class="mr-1">
											<span>{{ value['letter'].toUpperCase() }}</span>
											<span>({{ value['rating'] }})</span>
										</div>
									</template>
								</div>
							</dd>
						</template>
					</dl>
				</div>
				<template v-if="filtered_dictionary.length">
					<div class="list-group list-group-flush">
						<button type="button" class="list-group-item list-group-item-action list-group-item-secondary text-center" @click.prevent="reset">
							Сброс
							<template>({{ filtered_dictionary.length }})</template>
						</button>
						<template v-for="(word, key) in filtered_dictionary" v-key="key">
							<a :href="`https://ru.wiktionary.org/wiki/${word}`" class="list-group-item list-group-item-action text-primary" target="_blank">{{ word }}</a>
						</template>
					</div>
				</template>
			</div>

		</template>
  </div>
</template>

<script>

import Mixin5bukv from './mixins/Mixin5bukv'

export default {
  name: 'vue-5bukv',
	mixins: [ Mixin5bukv ],
  data: function () {
		return {
			error: null,
			id: null,
			exclude: [],
			include: [],
			subsequence: [null, null, null, null, null],
			waiting: false
			// Букварь и Словарь в Mixin5bukv
		}
  },
	computed: {
		filtered_dictionary: function () {
			return (this.include.length || this.exclude.length) ? this.dictionary.filter(word => {
				return this.non_excluded(word)
				&& this.all_included(word)
				&& this.in_subsequence(word)
				&& ! this.containsUppercase(word)
			}) : []
		},
		letter_rating: function () {
			let counted = {}, result = []
			this.primer.forEach(letter => {
				counted[letter] = 0
				this.filtered_dictionary.map(word => {
					for (let i = 0; i < word.length; i++) {
						if (word[i] == letter) counted[letter]++
					}
				})
			})
			this.primer.map((letter) => {
				if (counted[letter] > 0 && ! this.include.includes(letter)) {
					let obj = {}
					obj['letter'] = letter
					obj['rating'] = counted[letter]
					result.push(obj)
				}
			})
			result = _.orderBy(result, ['rating'], ['desc'])
			if (result.length > 5) result.length = 5
			return result
		}
	},
  created: function () { this.id = this.$options.name + this._uid },
  methods: {
		reset: function () {
			this.$set(this, 'exclude', [])
			this.$set(this, 'include', [])
			this.$set(this, 'subsequence', [null, null, null, null, null])
		},
		button_class: function (letter) {
			let included = this.include.includes(letter)
			let excluded = this.exclude.includes(letter)
			return {
				'btn-primary': included,
				'btn-secondary': excluded,
				'btn-light': ! included && ! excluded
			}
		},
		in_subsequence: function (word) {
			for (let index = 0; index < this.subsequence.length; index++) {
				const element = this.subsequence[index]
				if (element != null && element != word.split('')[index]) {
					return false
				}
			}
			return true
		},
		all_included: function (word) {
			let result = this.include.filter(letter => word.split('').includes(letter))
			return result.length == this.include.length
		},
		non_excluded: function (word) {
			let result = this.exclude.filter(letter => word.split('').includes(letter))
			return result.length == 0
		},
		containsUppercase: function (str) {
			return /[А-Я]/.test(str)
		},
		btn_clck: function (letter) {
			let state = 0, exclude = _.clone(this.exclude), include = _.clone(this.include)
			if (exclude.indexOf(letter) >= 0) state = 1
			if (include.indexOf(letter) >= 0) state = 2
			_.remove(exclude, (e) => e == letter)
			_.remove(include, (e) => e == letter)
			this.$set(this, 'exclude', exclude)
			this.$set(this, 'include', include)
			switch(state) {
				case 0:
					this.exclude.push(letter)
					break
				case 1:
					if (this.include.length < 5) this.include.push(letter)
					break
			}
		}
  }
};
</script>
