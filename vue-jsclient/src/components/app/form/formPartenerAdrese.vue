<template>
    <validate-window ref="validateWindowRef"
                     :cWidth=500
                     :cHeight=200
                     :cTypeWindows=1
    ></validate-window>

    <validate-window ref="infoWindowRef"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=5
    ></validate-window>

    <validate-window ref="redWindowRef"
                     :cWidth=400
                     :cHeight=200
                     :cTypeWindows=6
    ></validate-window>

    <validate-window ref="refYesNo"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNoButton"
    ></validate-window>

    <form-tab :ref = this.REF_FROM>
        <template v-slot:slotTitle>
            <div class="antet">
                <div class="buttons-container">
                    <div class="prime-button last-button">
                        <my-button  :ref=this.REF_BUTTON_ADD_ADRESS @click="this.setFormNewAdress" :heightButton=22 :buttonType=2 title="adauga adresa noua" :style="this.ICON_ADD_PARTENER.colorStyle">
                            <font-awesome-icon :icon=this.$constComponent.cfgIconPicture(this.ICON_ADD_PARTENER) size="1x" />
                        </my-button>
                    </div>
                </div>
                <div class="title">{{this.titleForm}}</div>
            </div>
        </template>
        <template v-slot:slotContent>

            <form>
                <table class="ff-form-table">
                    <tr>
                        <td class="label-left bold">
                            <label :for=INPUT_ADRESA.id>{{INPUT_ADRESA.caption}}</label></td>
                        <td class="control">
                            <input-field
                                    :ref = INPUT_ADRESA.ref
                                    :pConfig = INPUT_ADRESA
                            ></input-field>
                        </td>
                        <td class="control">
                            <my-dropdown-search :pUrlData="'searchTableTest'"
                                                :ref = INPUT_LOCALITATE.ref
                                                :pConfig = INPUT_LOCALITATE
                            ></my-dropdown-search>
                        </td>
                    </tr>


                </table>
            </form>





            <my-list-adress
                :ref = this.REF_LISTA_ADRESE
                :pConfig=this.cfgListaAdresaConfig
                @emitAdresaImplicita = "emitAdresaImplicita"
                @emitListRowSelection = 'emitListAdressRowSelection'
            ></my-list-adress>
        </template>

        <template v-slot:slotButton>
        </template>

    </form-tab>
</template>

<script>
    import AlertWindow      from "@/components/base/AlertWindow.vue";
    import FormTab          from "@/components/base/FormTab.vue";
    import InputField       from "@/components/base/InputField.vue";
    import DropDownSearch   from "@/components/base/DropDownSearch.vue";
    import CheckBox         from "@/components/base/CheckBox.vue";
    import Button           from "@/components/base/Button";
    import Lista            from "@/components/base/Lista";

    export default {
        components: {
            'form-tab': FormTab,
            'validate-window': AlertWindow,
            'input-field': InputField,
	        'my-dropdown-search': DropDownSearch,
            'check-box': CheckBox,
            'my-button': Button,
            'my-list-adress': Lista
        },
        name: "form-partener-adrese",
        created() {
            this.REF_FROM = 'refForm';
            this.REF_BUTTON_ADD_ADRESS = 'refButtonAddAdress';
            this.REF_LISTA_ADRESE = 'refListaAdresa';
	        this.INPUT_ADRESA = this.cfgAdresa();
	        this.INPUT_LOCALITATE = this.cfgLocalitate();

	        this.URL_SET_DEFAULT_ADRESS = this.$url.getUrl('setActivAdress');
            this.ICON_ADD_PARTENER =  this.$constComponent.ICON_PLUS_SQUARE("blue");
            this.cfgListaAdresaConfig = {
                header: [
                    this.$constList.getHeader(1, 'Adresa', 200, 'cAdresa', this.$constList.HEADER.CAPTION_TYPE_FIELD ),
                    this.$constList.getHeader(2, 'Localitate', 200, 'localitate', this.$constList.HEADER.CAPTION_TYPE_FIELD ),
                    this.$constList.getHeader(3, 'Adresa implicita', 100, 'null', this.$constList.HEADER.CAPTION_TYPE_ACTION)
                ],
                recordActionButon: [
                    // this.$constList.getActionButton(4, 'adresa implicita', 'emitButton', this.$constGrid.getIcon('fas','skull', '#adad00'), this.$constList.ACTION_BUTTON.TYPE_BUTTON, null),
                    this.$constList.getActionButton(5, 'adresa implicita', 'emitAdresaImplicita', null, this.$constList.ACTION_BUTTON.TYPE_CHECKBOX, this.$app.cfgCheckBox('ro', false))   // poate fi un singur checkbox pe linie, trebuie setat si filedNameForCheckBox, campul poate fi doar 1 si 0
                    // this.$constList.getActionButton(4, 'adresa implicita', 'emitCheckBox', this.$constGrid.getIcon('fas','skull', '#adad00')),
                ],
                cfg: { urlData: 'partenerAdressList', loadOnCreate: false, filedNameForCheckBox: 'activ', emitListRowSelection: 'emitListRowSelection'}
            },
            this.runtime = {
                sendDataToServer: false,
	            showModalLoadingDiv: false,
	            message: [],
                idPartner: -1,
                post: { idPk: null, field: {}, sqlAction: null},
	            postAdress: {idPk: null, idPartner: null, field: {}}
            };
            this.cfgtime = {
            };
        },
        emits: ['emitNewRecord'],
        mounted () {
        },
        methods: {

            showList: function (postData){
                  this.$refs[this.REF_LISTA_ADRESE].showList(postData);
            },
            serverGetDataList: function () {
            },
            serverCheckAdress: function (){


	            if(!this.runtime.sendDataToServer){
		            this.$refs.refYesNo.setCaption("Adresa partener");
		            this.$refs.refYesNo.setMessage("Activez adresa selectata?");
		            this.$refs.refYesNo.show();
	            }

	            if(this.runtime.sendDataToServer){
		            this.runtime.sendDataToServer = false;

		            this.axios
			            .post(this.URL_SET_DEFAULT_ADRESS, this.runtime.postAdress)
			            .then(response => {
				            if (response.data.succes){
					            if(this.MODE == this.$constFROM.MODE_NEW){
						            this.runtime.showModalLoadingDiv = true;
					            }

					            //this.getDataPartener(this.post.idPk);
					            //this.$refs.infoWindowRef.setCaption("Succes");
					            //this.$refs.infoWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
					            //this.$refs.infoWindowRef.show();
				            }
				            else {
					            //this.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate");
					            //this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
					            //this.$refs.validateWindowRef.show();
				            }

			            })
			            .catch(error => console.log(error))
			            .finally(() => {
				            this.runtime.showModalLoadingDiv = false;
			            	this.showList({idPartner: this.runtime.postAdress.idPartner});
			            });


	            }
            },
            setFormNewAdress: function (){
            },
	        emitListAdressRowSelection: function(target){
                if(target.tagName == 'DIV'){
                    // console.log(target.parentNode);
                    let tr = target.closest('tr');


                    console.log(tr);

                }
            },
            emitAdresaImplicita: function (checkBoxControl){

                this.runtime.postAdress.idPk = checkBoxControl.getAttribute("idPk");
	            this.runtime.postAdress.idPartner = this.runtime.idPartner;

                if(!checkBoxControl.checked){
                    // este deja bifat, nu fac nimic, refac bifa;
                    checkBoxControl.checked = true;
                } else {
                    checkBoxControl.checked = false;
                    this.serverCheckAdress();
                }

            },
            validateForm: function () {
            },
            resetfillForm: function () {
                this.titleForm = "...";
            },
            fillForm: function () {
            },
            setIdAndTitle: function (title, idPk){
              this.runtime.idPartner = idPk;
              this.titleForm =  title;

            },
            emitYesNoButton: function (yes) {
                if(yes == 1){
                    this.runtime.sendDataToServer = true;
	                this.serverCheckAdress();
                }else{
                    this.runtime.sendDataToServer = false;
                }
            },
	        setPostAdress: function (component, value){
    	        this.runtime.postAdress['field'][component.name] = value;
	        },
	        validateAdress: function (){
		        let value = this.$refs[this.INPUT_ADRESA.ref].getValue();
		        if(!this.$check.lenghtMinMax(value, this.INPUT_ADRESA.minLength, this.INPUT_ADRESA.maxLength)){
			        this.runtime.message.push(this.$app.getFormMessageClass(this.INPUT_ADRESA.id, this.INPUT_ADRESA.caption,
				        'trebuie sa aiba minim ' + this.INPUT_ADRESA.minLength + " si maxim " + this.INPUT_ADRESA.maxLength + " caractere"));
		        }

		        this.setPostAdress(this.INPUT_ADRESA, value);
            },
	        cfgLocalitate: function(){
		        let cfg = this.$app.cfgSelectSearch('nomLocalitati', this.$url.getUrl('nomLocalitati'), 220);
			        cfg.setValidateFunction(this.validateLocalitate);
			        cfg.setCaption("Localitate");
			        cfg.setMandatory(true);
			        return cfg;
            },

	        cfgAdresa: function(){
		        let cfg = this.$app.cfgInputField("adresa", 70);
		        cfg.setValidate(6,200);
		        cfg.setValidateFunction(this.validateAdress);
		        cfg.setCaption("Adresa");
		        cfg.setMandatory(true);
		        cfg.setMaska("");
		        return cfg;
	        },

            setPost: function (component, value){
            },
            setPostAction: function (value){
            }
        },
        data () {
            return {
                form: {message: []},
                titleForm: 'titlu programing time ... '
            }
        }
    }

</script>

<style scoped></style>
