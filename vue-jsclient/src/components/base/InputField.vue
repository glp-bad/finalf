
<template>
    <div class="ff-input-text" :ref=this.REF_DIV_CONTAINER>
        <input :id = this.pConfig.id
               :name = this.pConfig.name
               ref = "refInput"
               :placeholder=this.pConfig.placeHolder
               v-model = "dataModel"
               v-maska= this.pConfig.maska
               v-bind:class="{'disable-background': this.readOnly }"
               v-on:keyup="this.keyupPress"
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
		created() {
		    this.REF_DIV_CONTAINER='refIinputTextContainer'
        },
		mounted() {
			this.vModelData = null;
			if(!this.$check.isUndef(this.pConfig.defaultValue)){
                this.dataModel = this.pConfig.defaultValue;
            }

            if(!this.$check.isUndef(this.pConfig.width)) {
	            this.$refs[this.REF_DIV_CONTAINER].style.width = this.pConfig.width;
            }
            if(this.pConfig.readOnly){
                this.readOnly = this.pConfig.readOnly;
                this.$refs.refInput.setAttribute('readonly', this.pConfig.readOnly);
            }
			// document.addEventListener('keydown', this.keydownPress);

            // if(!this.$check.isUndef(this.pConfig.emitKeyUp)) {                document.addEventListener('keyup', this.keyupPress);            }
        },
        methods: {
			getValue: function () {
                return this.dataModel;
			},
	        setValue: function (value) {
		        this.dataModel = value;
	        },
            setFocus: function (){
                this.$refs.refInput.focus();
            },
            setReadOnly: function (readOnly) {
                if(readOnly) {
                    this.$refs.refInput.setAttribute('readonly', readOnly);
                }else{
                    this.$refs.refInput.removeAttribute('readonly');
                }

                this.readOnly = readOnly;
            },
            keyupPress: function (){
                if(!this.$check.isUndef(this.pConfig.emitKeyUp)) {
                    this.$emit(this.pConfig.emitKeyUp, this.dataModel);
                }
                /*
                if(!this.$check.isUndef(this.pConfig.emitKeyUp)) {
                    this.$emit("thispConfigemitKeyUp");
                }
                */

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
				dataModel: null,
                readOnly: false
            }
		}
	}

</script>

<style scoped>
</style>
