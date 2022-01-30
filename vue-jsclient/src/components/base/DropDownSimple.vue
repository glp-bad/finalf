<template>
    <div class="ff-dropdown-simple" >
        <div class = "loading-modal" v-if="this.showModalLoadingDiv">
            <div>
                <font-awesome-icon :icon=this.$constComponent.ICON_SPINNER size="1x" spin/>
            </div>
        </div>

        <select :name=pConfig.name :id=pConfig.id :ref=SELECT_REF @change="changeValue" :disabled=this.isDisabled>
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
            pConfig: {type: Object, required: true}
		},
		created() {
			this.SELECT_REF = 'selectRef'
        },
		mounted() {
			this.config();
        },
        methods: {
            getDataFromServer: function () {
                let $url = this.pConfig.url;
                this.isShowSelectedData = false;

                this.showModalLoadingDiv = true;
                this.axios
                    .post($url, this.post)
                    .then(response => {
                        this.showModalLoadingDiv = true;
                        this.dataList = response.data.records;
                    })
                    .catch(error => console.log(error))
                    .finally(() => {
                        this.showModalLoadingDiv = false;
                        if(!this.isShowSelectedData){
                            this.setValue(this.dataSelected.id);
                        }
                    });

            },
			changeValue: function () {
				let refSelect = this.$refs[this.SELECT_REF];
				this.setValue(refSelect.options[refSelect.selectedIndex].value);
				// this.setValue(refSelect.options[refSelect.selectedIndex].value, refSelect.options[refSelect.selectedIndex].text);
                // console.log(refSelect.options[refSelect.selectedIndex].value);
			},
            clearSelected: function(){
                this.dataSelected.id = -1;
                this.dataSelected.text = null;
                for(let i = 0; i<this.dataList.length; i++ ){
                        this.dataList[i].selected = false;
                }
            },
	        setValue: function (id) {
                this.dataSelected.id = id;
		        for(let i = 0; i<this.dataList.length; i++ ){
		            if(this.dataList[i].id == id){
                        this.dataSelected.text = this.dataList[i].text;
                        this.dataList[i].selected = true;
                        this.isShowSelectedData = true;
                    }else{
                        this.dataList[i].selected = false;
                    }
                }
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
            config: function () {
				if(this.pConfig.sizeField > 0){
					this.$refs[this.SELECT_REF].style.width = this.pConfig.sizeField + 'px';
                }
	            this.enabled(true);
				this.getDataFromServer();
            }
        },
        computed :{
        },
		data () {
			return {
                showModalLoadingDiv: true,
				dataList: [this.$constSelect.getRecordSelect('0','...')],
                dataSelected: {id: 0, text: null},
                isShowSelectedData: false,
                isDisabled: true,
                post: null
			}
		}
	}
</script>

<style scoped></style>
