
<template>
    <div class="ff-radio-button" :ref=this.REF_DIV_CONTAINER>
        <template v-for="ph in pConfig.buttons">
            <input class="inputClass" type="radio"
                    :id=ph.id :name=this.pConfig.name :value=ph.value
                    :checked=ph.check
                    :disabled=ph.disableOption
                   @click="this.privateEmitButtonClick($event, this.pConfig.emit)"

            >
            <label class="labelClass"
                   v-bind:class="{ 'disabled-option': ph.disableOption}"
                   :for=ph.id>{{ph.caption}}</label>
        </template>

    </div>
</template>

<script>

	import { maska } from 'maska'

	export default {
		name: "my-radio-button",
        props: {
            pConfig: {type: Object, required: true}
        },
		directives: { maska },
		created() {
		    this.REF_DIV_CONTAINER='refRadioButton',
			this.cfgtime = {
		    	CLASS_ALIGN_H: 'alignment-horizontally',
				CLASS_ALIGN_V: 'alignment-vertical'
            }
        },
		mounted() {
			this.privateConfig();
			this.getValue();
        },
        methods: {
	        getValue: function () {
	        	let buttons = this.$el.querySelectorAll("input");
	        	let valueReturn = null;

	        	for(let i=0; i < buttons.length; i++){
			        if (buttons[i].checked) {
				        valueReturn = buttons[i].value;
				        break;
                    }

                }

                return valueReturn;
	        },
	        privateEmitButtonClick: function(event, action){
		        this.$emit(action, event.target);
	        },
			privateConfig: function(){

				let classAlign = null;
				if(this.pConfig.alignment == this.$constRadioButton.ALIGNMENT_H) {
					classAlign = this.cfgtime.CLASS_ALIGN_H;

                }else{
					classAlign = this.cfgtime.CLASS_ALIGN_V;

                }

                this.$refs[this.REF_DIV_CONTAINER].classList.add(classAlign);

				// console.log(this.pConfig);
            }
        },
		data () {
			return {
            }
		}
	}

</script>

<style scoped>
</style>

