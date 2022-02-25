<template>
    <input type="checkbox" class="ff-checkbox"
           :checked = this.dataModel
           :id=this.pConfig.id
           :name=this.pConfig.id
           v-model="dataModel"
           @click="this.privateEmitButtonClick($event, this.pConfig.emit)"
    >
</template>

<script>
	export default {
		name: "my-checkBox",
        props: {
            pConfig: {type: Object, required: true},
            pCheck: {type: Boolean, required: false}
        },
		directives:{},
		mounted() {
			this.dataModel = this.pConfig.defaultValue;
			if(this.pCheck != undefined){
			    if(this.pCheck){
			        this.setValue(true);
                }
            }
        },
        methods: {
			getValue: function () {
                return this.dataModel;
			},
            setValue: function (val) {
                this.dataModel = val;
            },
	        resetValue: function () {
		        this.dataModel = this.pConfig.defaultValue;
	        },
	        keydownPress: function () {
	        },
            privateEmitButtonClick: function(event, action){
                this.$emit(action, event.target);
            },
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
