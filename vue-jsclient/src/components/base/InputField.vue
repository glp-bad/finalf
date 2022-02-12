
<template>
    <div class="ff-input-text">
        <input :id = this.pConfig.id
               :name = this.pConfig.name
               ref = "refInput"
               :size = this.pConfig.sizeField
               :placeholder=this.pConfig.placeHolder
               v-model = "dataModel"
               v-maska= this.pConfig.maska
        >
    </div>
</template>

<script>

	import { maska } from 'maska'

	export default {
		name: "my-inputField",
        props: {
            pConfig: {type: Object, required: true}
        },
		directives: { maska },
		mounted() {
			this.vModelData = null;
			// document.addEventListener('keydown', this.keydownPress);
			// document.addEventListener('keyup', this.keydownPress);
        },
        methods: {
			getValue: function () {
                return this.dataModel;
			},
	        setValue: function (value) {
		        this.dataModel = value;
	        },
	        keydownPress: function () {
			    /*
                if(event.target.id == this.pConfig.id){
	                console.log(this.getValue());
                }
                */

	        }
        },
		data () {
			return {
				dataModel: null
            }
		}
	}

</script>

<style scoped>
</style>
