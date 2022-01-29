<template>
    <input type="checkbox"
           :id=this.id
           :name=this.id
           :size=this.size
           v-model="dataModel"
           :disabled = this.disabled
    >
</template>

<script>
	export default {
		name: "my-checkBox",
        props: {
            id: String,
            caption: String,
            validate: Function,
	        defaultValue: Boolean,
            disabled: Boolean,
	        size: Number
        },
		directives:{},
		mounted() {
			this.dataModel = this.defaultValue;
        },
        methods: {
			getValue: function () {
                return this.dataModel;
			},
            setValue: function (val) {
                this.dataModel = val;
            },
	        resetValue: function () {
		        this.dataModel = this.defaultValue;
	        },
	        keydownPress: function () {
	        }
        },
		data () {
			return {
				dataModel: true
            }
		}
	}
</script>

<style scoped>
</style>
