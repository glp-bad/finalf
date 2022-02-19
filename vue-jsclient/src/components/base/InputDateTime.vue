
<template>
    <div class="ff-input-text">
        <input :id = this.pConfig.id
               :name = this.pConfig.name
               ref = "refInput"
               :size = this.pConfig.sizeField
               :placeholder=this.pConfig.placeHolder
               v-model = "dataModel"
               v-maska= this.pConfig.maska
               v-bind:class="{'disable-background': this.readOnly }"
        >
    </div>
</template>

<script>

	import { maska } from 'maska'

	export default {
		name: "my-inputDatetime",
        props: {
            pConfig: {type: Object, required: true}
        },
		directives: { maska },
		mounted() {
			this.vModelData = null;
			// document.addEventListener('keydown', this.keydownPress);
			// document.addEventListener('keyup', this.keydownPress);
            this.config();
        },
        methods: {
			getValue: function () {
                return this.dataModel;
			},
            getSplitValue: function (){
			    let splitData = this.dataModel.split(this.$constBussines.DATE_DISPLAY_SEPARATOR);
                return  {year: splitData[2] , month: splitData[1] , day: splitData[0]};
            },
            setReadOnly: function (readOnly) {
			    if(readOnly) {
                    this.$refs.refInput.setAttribute('readonly', readOnly);
                }else{
                    this.$refs.refInput.removeAttribute('readonly');
                }

                this.readOnly = readOnly;
            },
	        setValue: function (value) {
		        this.dataModel = value;
	        },
            setValueFromSqlFormat: function (value) {
                let dataFormat = this.$datetime.convertDataSqlFormatToView(value);
                this.dataModel = dataFormat;
            },
	        keydownPress: function () {
			    /*
                if(event.target.id == this.pConfig.id){
	                console.log(this.getValue());
                }
                */

	        },
            config: function () {
			    let startEndCurrentMonth = this.$startEndCurrentMonth();
                let returnDate = null;

			    if(this.pConfig.dateShowDefault == this.$constBussines.DATE_CURRENT){
                    returnDate = startEndCurrentMonth.currentDate;
                }else if(this.pConfig.dateShowDefault == this.$constBussines.DATE_FIRSTDAY){
                    returnDate = startEndCurrentMonth.monthIn;
                }else if(this.pConfig.dateShowDefault == this.$constBussines.DATE_LASTDAY){
                    returnDate = startEndCurrentMonth.monthSf;
                }

                this.setValue(returnDate);
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
