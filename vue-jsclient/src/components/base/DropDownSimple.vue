<template>
    <div class="ff-dropdown-simple">
        <select :name=pName :id=pId :ref=SELECT_REF @change="changeValue" :disabled=this.isDisabled>
            <option v-for="dval in dataList" :value=dval.id :selected="dval.selected">
                    {{dval.text}}
            </option>
        </select>
    </div>
</template>

<script>
	export default {
		name: "my-dropDown-simple",
		props: {
			pId: String,
			pName: String,
            pCaptionText: String,
            pWidth: Number,
			validate: Function
		},
		created() {
			this.SELECT_REF = 'selectRef'
        },
		mounted() {
			this.config();
        },
        methods: {
			changeValue: function () {
				let refSelect = this.$refs[this.SELECT_REF];
				this.setValue(refSelect.options[refSelect.selectedIndex].value, refSelect.options[refSelect.selectedIndex].text);
			},
	        setValue: function (id, text) {
		        this.dataSelected.id = id;
		        this.dataSelected.text = text;
	        },
	        getValue: function () {
		        return this.dataSelected;
	        },
            enabled: function (isEnabled) {
				if(isEnabled){
					this.isDisabled = false;
                }else{
					this.isDisabled = true;
                }
            },
		    dataTest: function () {

			    let datatest = [{id:0, text:this.pCaptionText, selected: true}];

				 datatest.push(
					{id: 100, text: 'cifra 100', selected: false},
					{id: 200, text: 'cifra 200', selected: false},
					{id: 300, text: 'cifra 300', selected: false},
					{id: 400, text: 'cifra 400', selected: false},
					{id: 500, text: 'cifra 500 un text mult mai lung', selected: false},
					{id: 600, text: 'cifra 600', selected: false}
				);



                return datatest;
		    },
            config: function () {
				if(this.pWidth > 0){
					this.$refs[this.SELECT_REF].style.width = this.pWidth + 'px';
                }

	            this.enabled(true);
            }
        },
        computed :{
        },
		data () {
			return {
				dataList: this.dataTest(),
                dataSelected: {id: 0, text: null},
                isDisabled: true
			}
		}
	}
</script>

<style scoped></style>