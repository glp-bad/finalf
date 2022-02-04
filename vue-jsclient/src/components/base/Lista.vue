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
                                <td class="tdClass" v-if="privateCfgFieldShow(index)">
                                        <div class="tdDiv"> {{td}} </div>
                                </td>
                            </template>

                            <!-- -------------------------------------------------------------------- -->
                            <td class="tdClass">
                                <div  class="tdDivCenterAlign">
                                    <div class="toolbar-icon-inline" >
                                        <template v-for="ph in pConfig.recordActionButon">
                                            <div class="divButton">
                                                <my-button @click="this.privateCfgEmitAction($event, ph.emitAction)" :heightButton=22 :buttonType=1 :title="ph.tooltip" :style=privateCfgIconColor(ph.icon.color)>
                                                    <font-awesome-icon :icon=this.privateCfgIconPictureAction(ph.icon) size="1x"/>
                                                </my-button>
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

	export default {
		name: "my-lista",
        components: {
            'my-button': Button
        },
        props: {
            pConfig: {type: Object, required: true}
        },
		directives: {},
        created() {
			this.runtime = {
				fieldArray: []
            },
			this.privateSetRuntimeData()
        },
        mounted() {
		    if(this.pConfig.cfg.loadOnCreate) {
                this.showList();
            }
        },
        methods: {
		    showList: function (){
                this.getDataFromServer();
            },
            getDataFromServer: function () {
                this.showModalLoadingDiv = true;

                let uri = this.$url.getUrl(this.pConfig.cfg.urlData);
                this.axios
                    .post(uri, this.post)
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
            privateCfgEmitAction:function(event, action) {
                // this.cfgMouseNavigate(event);
                //this.$emit(action, this.selectdRow);
            },
            privateCfgFieldShow(fieldName) {
	            return this.runtime.fieldArray.includes(fieldName);

            },
            privateCfgTypeField(type) {
                return this.runtime.fieldArray.includes(fieldName);
            },
	        privateSetRuntimeData() {
	            this.pConfig.header.forEach(h => {
		            this.runtime.fieldArray.push(h.fieldName);
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
