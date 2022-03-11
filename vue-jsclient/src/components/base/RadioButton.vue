
<template>
    <div class="ff-radio-button" :ref=this.REF_DIV_CONTAINER>
        <template v-for="ph in this.buttonsCfg">
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

	export default {
		name: "my-radio-button",
        props: {
            pConfig: {type: Object, required: true}
        },
		directives: {},
		created() {
		    this.REF_DIV_CONTAINER='refRadioButton',
			this.cfgtime = {
		    	CLASS_ALIGN_H: 'alignment-horizontally',
				CLASS_ALIGN_V: 'alignment-vertical'
            }
        },
		mounted() {
			this.buttonsCfg = this.pConfig.buttons;
			this.privateConfig();
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
            setCheck: function (value){
	            for(let i=0; i< this.buttonsCfg.length; i++){
		            if(this.buttonsCfg[i].value == value){
			            this.buttonsCfg[i].check = true;
                    }else{
			            this.buttonsCfg[i].check = false;
                    }
	            }
            },
	        resetSelection: function(){
		        for(let i=0; i< this.buttonsCfg.length; i++){
			        this.buttonsCfg[i].check = false;
		        }
	        },
            disabledAll: function(disabled){
	            for(let i=0; i< this.buttonsCfg.length; i++){
		            this.buttonsCfg[i].disableOption = disabled;
                }
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

            }
        },
		data () {
			return {
				buttonsCfg:[]
            }
		}
	}

</script>

<style scoped>
</style>

