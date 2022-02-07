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
                        <my-button  :ref=this.REF_BUTTON_ADD_ADRESS @click="this.setFormNewAdress" :heightButton=22 :buttonType=2 title="adaug adresa noua" :style="this.ICON_ADD_PARTENER.colorStyle">
                            <font-awesome-icon :icon=this.$constComponent.cfgIconPicture(this.ICON_ADD_PARTENER) size="1x" />
                        </my-button>
                    </div>
                </div>
                <div class="title">{{this.titleForm}}</div>
            </div>
        </template>
        <template v-slot:slotContent>
            <my-list-adress
                :ref = this.REF_LISTA_ADRESE
                :pConfig=this.cfgListaAdresaConfig
                @emitAdresaImplicita = "emitAdresaImplicita"
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
    import DropDownSimple   from "@/components/base/DropDownSimple.vue";
    import CheckBox         from "@/components/base/CheckBox.vue";
    import Button           from "@/components/base/Button";
    import Lista            from "@/components/base/Lista";

    export default {
        components: {
            'form-tab': FormTab,
            'validate-window': AlertWindow,
            'input-field': InputField,
            'type-partener': DropDownSimple,
            'check-box': CheckBox,
            'my-button': Button,
            'my-list-adress': Lista
        },
        name: "form-partener-adrese",
        created() {
            this.REF_FROM = 'refForm';
            this.REF_BUTTON_ADD_ADRESS = 'refButtonAddAdress';
            this.REF_LISTA_ADRESE = 'refListaAdresa';
	        this.URL_SET_DEFAULT_ADRESS = this.$url.getUrl('setActivAdress');
            this.ICON_ADD_PARTENER =  this.$constComponent.ICON_ADD_PERSON("blue");
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
                cfg: { urlData: 'partenerAdressList', loadOnCreate: false, filedNameForCheckBox: 'activ'}
            },
            this.runtime = {
                sendDataToServer: false,
	            showModalLoadingDiv: false,
                idPartner: -1,
                post: { idPk: null, field: {}, sqlAction: null},
	            postAdress: {idPk: null, idPartner: null}
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
            serverGetDataList: function (idPk) {
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
						            this.post.idPk = response.data.lastId;
						            this.$emit(this.EMIT_NEW_RECORD, this.post.idPk);
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
			            	this.showList({idPartner: this.runtime.postAdress.idPk});
			            });


	            }
            },
            setFormNewAdress: function (){
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
