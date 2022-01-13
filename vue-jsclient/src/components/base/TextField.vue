
<template>
    <div class="ff-input-text">
        <input :id = this.id
               :name = this.id
               :minlength = this.minlength
               :maxlength = this.maxlength
               v-model = "dataModel"
               ref = "inputRef"
               :size = this.size
               :placeholder=this.pPlaceHolder>
    </div>
</template>

<script>

	import { maska } from 'maska'

	export default {
		name: "my-textField",
        props: {
            id: String,
            maska: String,
            validate: Function,
            minlength: Number,
	        maxlength: Number,
	        size: Number,
	        pPlaceHolder:  {
			        type: String,
			        default: 'input data ...',
			        required: false
		        }

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
	        keydownPress: function () {
                if(event.target.id == this.id){
	                console.log(this.getValue());
                }
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
