<template>
    <div class="ff-lista">
        <div class="container" :ref=this.cfgTime.REF_CONTAINER>
            <div class = "loading-modal" v-if="this.showModalLoadingDiv">
                <div>
                    <font-awesome-icon :icon=this.$constComponent.ICON_SPINNER size="4x" spin/>
                </div>
            </div>

            <table class="tableClass">

              <!-- ---------------------------------------------------------------------------------------------- -->
              <thead class="theadClass">
                <tr>
                    <template v-for="ph in pConfig.header">
                        <th v-if="ph.type === this.$constList.HEADER.CAPTION_TYPE_FIELD" class="thClass"><div :style="this.privateCfsTHStyle(ph)">{{ph.caption}}</div></th>
                        <th v-if="ph.type === this.$constList.HEADER.CAPTION_TYPE_ACTION" class="thClass">{{ph.caption}}</th>
                    </template>
                </tr>
              </thead>
              <!-- ---------------------------------------------------------------------------------------------- -->

              <!-- ---------------------------------------------------------------------------------------------- -->
              <tbody class="tbodyClass">
                  <template v-for="(tr, index) in this.dataList">
                        <tr class="trClass" :idPk="tr.id" @click="this.privateCfgEmitRowSelection($event, this.pConfig.cfg.emitListRowSelection)">
                            <template v-for="(td, index) in tr" v-bind:key="index">
                                <td class="tdClass" v-if="privateCfgFieldShow(index, tr)" :field=index>
                                        <div :na="this.privateCfgTDAlign(index)" :class="{tdDivRightAlign, tdDivLeftAlign, tdDivCenterAlign}">{{td}}</div>
                                </td>
                            </template>

                            <!-- -------------------------------------------------------------------- -->
                            <td class="tdClass" v-if="this.privateCfgHaveButton()">
                                <div  class="tdDivCenterAlign">
                                    <div class="toolbar-icon-inline" >
                                        <template v-for="ph in pConfig.recordActionButon">
                                            <div v-if="ph.typeButton === this.$constList.ACTION_BUTTON.TYPE_BUTTON" class="divButton">
                                                <my-button @click.prevent="this.privateCfgEmitAction($event, ph.emitAction)" :heightButton=22 :buttonType=1 :title="ph.tooltip" :style=privateCfgIconColor(ph.icon.color)>
                                                    <font-awesome-icon :icon=this.privateCfgIconPictureAction(ph.icon) size="1x"/>
                                                </my-button>
                                            </div>
                                            <div v-if="ph.typeButton === this.$constList.ACTION_BUTTON.TYPE_CHECKBOX" class="divButton">
                                                <my-checkBox @click="this.privateCfgEmitCheckBoxEmitAction($event, ph.emitAction)" :idPk = this.idPk
                                                    :pConfig = ph.cfgCheckBox
                                                    :ref= ph.cfgCheckBox.ref
                                                    :pCheck = privateCfgSetCheckBox()
                                                ></my-checkBox>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </td>
                            <!-- -------------------------------------------------------------------- -->

                        </tr>
                  </template>
              </tbody>
              <!-- ---------------------------------------------------------------------------------------------- -->

            </table>

        </div>
    </div>
</template>
<script>

    import Button   from "@/components/base/Button";
    import CheckBox from "@/components/base/CheckBox";

	export default {
		name: "my-lista",
        components: {
            'my-button': Button,
            'my-checkBox': CheckBox
        },
        props: {
            pConfig: {type: Object, required: true}
        },
		directives: {},
        created() {
	        this.tdDivRightAlign= false,              // class align
		    this.tdDivLeftAlign = false,               // class align
		    this.tdDivCenterAlign= false,             // class align
			this.cfgTime = {
				REF_CONTAINER: 'refContainer',
                CLASS_DIMENSION: 'with-dimension',
				fieldArray: [],
                checkBoxValue: null,
                idPk: null,
                headerArrayObject: {},
				totalWidth: 0
            },
            this.runtime = {
                post: null,
                responseCustom: null
            },
			this.privateCfgSetData()
        },
        mounted() {
		    if(this.pConfig.cfg.loadOnCreate) {
                this.showList();
            }

	        this.privateCfgList();
        },
        methods: {
			getTotalWidth: function () {
                return this.cfgTime.totalWidth;
			},
		    getDataList: function(){
		      return this.dataList;
            },
            getCustomResponse: function(){
                return this.runtime.responseCustom;
            },
		    showList: function (postData){
		        if(!this.$check.isUndef(postData)){
    		        this.runtime.post = postData;
                }

                this.getDataFromServer();

                return 'ff';
            },
            getDataFromServer: function () {
                this.showModalLoadingDiv = true;
                this.runtime.responseCustom = null;
	            this.dataList = null;                   // reset list

                let uri = this.$url.getUrl(this.pConfig.cfg.urlData);
                this.axios
                    .post(uri, this.runtime.post)
                    .then(response => {
                        this.showModalLoadingDiv = true;
                        this.dataList = response.data.records;
                        this.runtime.responseCustom = response.data.custom;

                    })
                    .catch(error => console.log(error))
                    .finally(() => {
                        this.$emit('emitFinallyCustomResponse', this.runtime.responseCustom);
                        this.showModalLoadingDiv = false;
                    });

            },
            privateCfgIconPictureAction: function (icon) {
                return [icon.fawIcon, icon.icon];
            },
            privateCfgIconColor: function (color) {
                return {
                    color: color
                }
            },
	        privateCfgEmitRowSelection: function(event, action){
		        this.$emit(action, event.target);
            },
            privateCfgEmitCheckBoxEmitAction:function(event, action) {
                this.$emit(action, event.target);
            },
            privateCfgEmitAction:function(event, action) {
                this.$emit(action, event.target);
            },
            privateCfgSetCheckBox:function() {
		        let returnVal = false;
		        if(this.cfgTime.checkBoxValue == 1){
                    returnVal = true;
                }

		        return returnVal;
            },
            privateCfgHaveButton: function (){
                 if(this.pConfig.recordActionButon.length > 0) {
                     return true;
                 }
                 return false;
            },
            privateCfgFieldShow(fieldName, tr) {
		        this.idPk = tr.id;
		        if(this.pConfig.cfg.filedNameForCheckBox == fieldName){
		            if(tr[this.pConfig.cfg.filedNameForCheckBox] == 1){
                        this.cfgTime.checkBoxValue = true;
                    }else{
                        this.cfgTime.checkBoxValue = false;
                    }
                }
	            return this.cfgTime.fieldArray.includes(fieldName);
            },
	        privateCfgSetData() {

		    	let totalWidth = 0;

	            this.pConfig.header.forEach(h => {
		            this.cfgTime.fieldArray.push(h.fieldName);
		            this.cfgTime.headerArrayObject[h.fieldName] = h;
		            totalWidth = totalWidth + h.width;
	            });

		        this.cfgTime.totalWidth = totalWidth;
            },
            privateCfsTHStyle: function (cf) {
		        if(!this.$check.isUndef(this.pConfig.cfg.headerLenghtActivate) && this.pConfig.cfg.headerLenghtActivate){
                    return {
                        width: cf.width + 'px'
                    }
                }

            },
	        privateCfgTDAlign: function (fieldName) {
                let align = this.cfgTime.headerArrayObject[fieldName].alignText;

		        this.tdDivRightAlign= false;
			    this.tdDivLeftAlign = false;
			    this.tdDivCenterAlign= false;

		        if(align == this.$constComponent.ALIGN_TEXT_LEFT){
			        this.tdDivLeftAlign  = true;
		        }else if(align ==  this.$constComponent.ALIGN_TEXT_RIGHT){
			        this.tdDivRightAlign = true;
		        }else if(align == this.$constGrid.ALIGN_TEXT_CENTER){
			        this.tdDivCenterAlign = true;
		        }

	        },
            privateCfgList(){
		    	if(!this.$check.isUndef(this.pConfig.cfg.heightList)){
                    let divContainer = this.$refs[this.cfgTime.REF_CONTAINER];

				    divContainer.classList.add(this.cfgTime.CLASS_DIMENSION);
				    divContainer.style.height = this.pConfig.cfg.heightList + 'px';
                }
            }
        },
		data () {
			return {
                showModalLoadingDiv: false,
                dataList: []
            }
		}
	}

</script>

<style scoped>
</style>
