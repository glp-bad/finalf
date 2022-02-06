<template>
    <div class="ff-lista">
        <div class="container">

            <table class="tableClass">

              <!-- ---------------------------------------------------------------------------------------------- -->
              <thead class="theadClass">
                <tr>
                    <template v-for="ph in pConfig.header">
                        <th v-if="ph.type === this.$constList.HEADER.CAPTION_TYPE_FIELD" class="thClass">{{ph.caption}}</th>
                        <th v-if="ph.type === this.$constList.HEADER.CAPTION_TYPE_ACTION" class="thClass">{{ph.caption}}</th>
                    </template>
                </tr>
              </thead>
              <!-- ---------------------------------------------------------------------------------------------- -->

              <!-- ---------------------------------------------------------------------------------------------- -->
              <tbody class="tbodyClass">
                  <template v-for="(tr, index) in this.dataList">
                        <tr class="trClass" :idPk="tr.id">
                            <template v-for="(td, index) in tr" v-bind:key="index">
                                <td class="tdClass" v-if="privateCfgFieldShow(index, tr)">
                                        <div class="tdDiv"> {{td}} </div>
                                </td>
                            </template>

                            <!-- -------------------------------------------------------------------- -->
                            <td class="tdClass">
                                <div  class="tdDivCenterAlign">
                                    <div class="toolbar-icon-inline" >
                                        <template v-for="ph in pConfig.recordActionButon">
                                            <div v-if="ph.typeButton === this.$constList.ACTION_BUTTON.TYPE_BUTTON" class="divButton">
                                                <my-button @click="this.privateCfgEmitAction($event, ph.emitAction)" :heightButton=22 :buttonType=1 :title="ph.tooltip" :style=privateCfgIconColor(ph.icon.color)>
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

    import Button       from "@/components/base/Button";
    import CheckBox       from "@/components/base/CheckBox";

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
			this.cfgTime = {
				fieldArray: [],
                checkBoxValue: null,
                idPk: null
            },
            this.runtime = {
                post: null
            },
			this.privateCfgSetData()
        },
        mounted() {
		    if(this.pConfig.cfg.loadOnCreate) {
                this.showList();
            }
		    console.log(this.pConfig.recordActionButon)
        },
        methods: {
		    showList: function (postData){
		        if(!this.$check.isUndef(postData)){
    		        this.runtime.post = postData;
                }
                this.getDataFromServer();
            },
            getDataFromServer: function () {
                this.showModalLoadingDiv = true;

                let uri = this.$url.getUrl(this.pConfig.cfg.urlData);
                this.axios
                    .post(uri, this.runtime.post)
                    .then(response => {
                        this.showModalLoadingDiv = true;
                        this.dataList = response.data;
                    })
                    .catch(error => console.log(error))
                    .finally(() => {
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
	            this.pConfig.header.forEach(h => {
		            this.cfgTime.fieldArray.push(h.fieldName);
	            });
            }
        },
		data () {
			return {
                showModalLoadingDiv: false,
                dataList: null
            }
		}
	}

</script>

<style scoped>
</style>
