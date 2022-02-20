<template>
    <div class="ff-dropdown-simple" >
        <div class = "loading-modal" v-if="this.showModalLoadingDiv">
            <div>
                <font-awesome-icon :icon=this.$constComponent.ICON_SPINNER size="1x" spin/>
            </div>
        </div>

        <select :name=pConfig.name :id=pConfig.id :ref=SELECT_REF @change="changeValue" :disabled=this.isDisabled v-bind:class="{'disable-background': this.readOnly }">
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
			this.SELECT_REF = 'selectRef',
            this.EMIT_CHANGE = 'emitChange'
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

                        let list = [this.$constSelect.getRecordSelect(0,this.pConfig.placeHolder)];
                        this.dataList = list.concat(response.data.records);
                    })
                    .catch(error => console.log(error))
                    .finally(() => {
                        this.showModalLoadingDiv = false;
                        if(!this.isShowSelectedData){
                            this.setDefaultValue();
                        }
                    });
            },
			changeValue: function () {
				let refSelect = this.$refs[this.SELECT_REF];
				this.setValue(refSelect.options[refSelect.selectedIndex].value);
                this.$emit(this.EMIT_CHANGE, this.getValue());

				// this.setValue(refSelect.options[refSelect.selectedIndex].value, refSelect.options[refSelect.selectedIndex].text);
                // console.log(refSelect.options[refSelect.selectedIndex].value);
			},
            clearSelected: function(){
                this.dataSelected.id = -1;
                this.dataSelected.text = null;
                this.dataSelected.candidateKey = null;
                for(let i = 0; i<this.dataList.length; i++ ){
                        this.dataList[i].selected = false;
                }
            },
	        setValue: function (id) {
                if(!this.$check.isUndef(this.dataList)) {
                    this.dataSelected.id = id;
                    for (let i = 0; i < this.dataList.length; i++) {
                        if (this.dataList[i].id == id) {
                            this.dataSelected.text = this.dataList[i].text;
                            this.dataSelected.candidateKey = this.dataList[i].cTipAbrev;
                            this.dataList[i].selected = true;
                            this.isShowSelectedData = true;
                        } else {
                            this.dataList[i].selected = false;
                        }
                    }
                }
	        },
	        getValue: function () {
		        return this.dataSelected;
	        },
            setReadOnly: function (readOnly) {
                if(readOnly){
                    this.isDisabled = true;
                }else{
                    this.isDisabled = false;
                }

                this.readOnly = readOnly;
            },
            /**
             * deprecated use setReadOnly
             * @param isEnabled
             */
            enabled: function (isEnabled) {
				if(isEnabled){
					this.isDisabled = false;
                }else{
					this.isDisabled = true;
                }
            },
            setDefaultValue: function(){
              if(!this.$check.isUndef(this.pConfig.defaultValue)){
                  let id = 0;
                  for(let i=0; i < this.dataList.length; i++){
                      if(this.dataList[i].id == this.pConfig.defaultValue.id){
                          this.dataList[i].selected = true;
                          id = this.pConfig.defaultValue.id;
                          break;
                      }
                  }

                  this.setValue(id);
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
				dataList: null,
                dataSelected: {id: 0, text: null, candidateKey: null},
                isShowSelectedData: false,
                isDisabled: true,
                post: null,
                readOnly: false
			}
		}
	}
</script>

<style scoped></style>
