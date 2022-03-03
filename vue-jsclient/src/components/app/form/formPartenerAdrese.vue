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

    <validate-window ref="refYesNoNewAdress"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNoButtonAdaugAdressaNou"
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
                        <td class="control">

                            <div class="buttons">
                                &nbsp;
                                &nbsp;
                                &nbsp;
                                <my-button :ref=this.REF_BUTTON_UPDATE_ADRESS @click="this.serverEditAdress" :heightButton=22 :buttonType=0 title="modific adresa">{{this.captionButton}}</my-button>
                            </div>
                        </td>
                    </tr>
             </table>
             <br>

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
            this.REF_BUTTON_UPDATE_ADRESS = 'refButtonUpdateAdress';
            this.REF_LISTA_ADRESE = 'refListaAdresa';
	        this.INPUT_ADRESA = this.cfgAdresa();
	        this.INPUT_LOCALITATE = this.cfgLocalitate();
	        this.URL_SET_DEFAULT_ADRESS = this.$url.getUrl('setActivAdress');
            this.URL_SET_EDIT_ADRESS = this.$url.getUrl('editAdressPartener');
            this.ICON_ADD_PARTENER =  this.$constComponent.ICON_PLUS_SQUARE("blue");
            this.cfgListaAdresaConfig = {
                header: [
                    this.$constList.getHeader(1, 'Adresa', 700, 'cAdresa', this.$constList.HEADER.CAPTION_TYPE_FIELD ),
                    this.$constList.getHeader(2, 'Localitate', 180, 'localitate', this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER  ),
                    this.$constList.getHeader(3, 'Adresa implicita', 110, 'null', this.$constList.HEADER.CAPTION_TYPE_ACTION)
                ],
                recordActionButon: [
                    // this.$constList.getActionButton(4, 'adresa implicita', 'emitButton', this.$constGrid.getIcon('fas','skull', '#adad00'), this.$constList.ACTION_BUTTON.TYPE_BUTTON, null),
                    this.$constList.getActionButton(5, 'adresa implicita', 'emitAdresaImplicita', null, this.$constList.ACTION_BUTTON.TYPE_CHECKBOX, this.$app.cfgCheckBox('ro', false))   // poate fi un singur checkbox pe linie, trebuie setat si filedNameForCheckBox, campul poate fi doar 1 si 0
                    // this.$constList.getActionButton(4, 'adresa implicita', 'emitCheckBox', this.$constGrid.getIcon('fas','skull', '#adad00')),
                ],
                cfg: { urlData: 'partenerAdressList', loadOnCreate: false, filedNameForCheckBox: 'activ',
	                   headerLenghtActivate: true,                         // tine cont de lungimea coloanelor setate in header
                       emitListRowSelection: 'emitListRowSelection'
                    }
            },
            this.runtime = {
                mode: this.$constFROM.MODE_EDIT,
                sendDataToServer: false,
	            showModalLoadingDiv: false,
	            message: [],
                idPartner: -1,
                post: { idPk: null, field: {}, sqlAction: null},
	            postAdress: {idPk: null, idPartner: null, sqlAction: null, field: {}},
                selectRecordFromLista: {idPk: null, localitate: null, adresa: null, idLocalitate: null}
            };
            this.cfgtime = {
            };
        },
        emits: ['emitNewRecord'],
        mounted () {
            this.$refs[this.REF_BUTTON_UPDATE_ADRESS].disable(true);
        },
        methods: {

            showList: function (postData){
                  this.$refs[this.REF_BUTTON_UPDATE_ADRESS].disable(true);
                  this.$refs[this.REF_LISTA_ADRESE].showList(postData);
            },
            serverEditAdress: function (){
                if(this.validateForm()){
                    this.$refs.validateWindowRef.show();

                    return false;
                }

                if(!this.runtime.sendDataToServer){

                    let msg = "nimic";

                    if(this.runtime.mode == this.$constFROM.MODE_EDIT){
                        msg = "Editez adresa ?";
                    }else if(this.runtime.mode == this.$constFROM.MODE_NEW){
                        msg = "Adaug adresa ? <br> Adresa noua devine automat adresa implicita.";
                    }

                    this.$refs.refYesNoNewAdress.setCaption("Adresa");
                    this.$refs.refYesNoNewAdress.setMessage(msg);
                    this.$refs.refYesNoNewAdress.show();
                }

                if(this.runtime.sendDataToServer) {
                    this.runtime.sendDataToServer = false;

                    this.axios
                        .post(this.URL_SET_EDIT_ADRESS, this.runtime.postAdress)
                        .then(response => {
                            if (response.data.succes){

                                this.runtime.showModalLoadingDiv = true;
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

                            // if(this.runtime.mode == this.$constFROM.MODE_EDIT){ }

                            if(this.runtime.mode == this.$constFROM.MODE_NEW){
                                this.setModeForm(this.$constFROM.MODE_EDIT);
                            }

                            this.resetfillForm();
                            this.showList({idPartner: this.runtime.postAdress.idPartner});


                        });
                }

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
						        this.runtime.showModalLoadingDiv = true;
				            }
				            else {
                                this.$refs.validateWindowRef.setCaption("Adresa nu poate fi setata");
                                this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
                                this.$refs.validateWindowRef.show();
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
                this.setModeForm(this.$constFROM.MODE_NEW);
            },
            setModeForm: function (mode){
                this.runtime.mode = mode;

                if(this.runtime.mode == this.$constFROM.MODE_EDIT){
                    this.runtime.postAdress.sqlAction = this.$constComponent.SQL_UPDATE;
                    this.$refs[this.REF_BUTTON_ADD_ADRESS].disable(false);
                    this.captionButton = "Modific adresa";
                }

                if(this.runtime.mode == this.$constFROM.MODE_NEW){
                    this.$refs[this.REF_BUTTON_ADD_ADRESS].disable(true);
                    this.runtime.postAdress.sqlAction = this.$constComponent.SQL_INSERT;
                    this.captionButton = "Adaug adresa";
                    this.resetfillForm();
                    this.$refs[this.REF_BUTTON_UPDATE_ADRESS].disable(false);
                }

            },
	        emitListAdressRowSelection: function(target){
                if(target.tagName == 'DIV'){
                    // console.log(target.parentNode);
                    let tr = target.closest('tr');

                    for(let i=0;i<tr.children.length;i++){
                        if(tr.children[i].getAttribute('field') == 'cAdresa'){
                            this.runtime.selectRecordFromLista.adresa = tr.children[i].firstChild.textContent;
                        }else if(tr.children[i].getAttribute('field') == 'localitate'){
                            this.runtime.selectRecordFromLista.localitate = tr.children[i].firstChild.textContent;
                        }
                    }

                    // runtime data selected form list
                    this.runtime.selectRecordFromLista.idPk = tr.getAttribute('idPk');
                    this.runtime.selectRecordFromLista.idLocalitate = this.$vanilla.getAtributeValueFromArrayObject(this.$refs[this.REF_LISTA_ADRESE].getDataList(), 'id', this.runtime.selectRecordFromLista.idPk, 'id_localitate');

                    this.runtime.postAdress.idPk = this.runtime.selectRecordFromLista.idPk;

                    this.setModeForm(this.$constFROM.MODE_EDIT);

                    this.fillForm();
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
            resetfillForm: function () {
                this.$refs[this.INPUT_ADRESA.ref].setValue('');
                this.$refs[this.INPUT_LOCALITATE.ref].setDataSelected( {id: -1, caption: ''} );
            },
            fillForm: function () {
                this.$refs[this.INPUT_ADRESA.ref].setValue(this.runtime.selectRecordFromLista.adresa);
                this.$refs[this.INPUT_LOCALITATE.ref].setDataSelected( {id: this.runtime.selectRecordFromLista.idLocalitate, caption: this.runtime.selectRecordFromLista.localitate} );
                this.$refs[this.REF_BUTTON_UPDATE_ADRESS].disable(false);
            },
            setIdAndTitle: function (title, idPk){
              this.runtime.idPartner = idPk;
              this.titleForm =  title;

            },
            emitYesNoButtonAdaugAdressaNou: function (yes) {
                if(yes == 1){
                    this.runtime.sendDataToServer = true;
                    this.serverEditAdress();
                }else{
                    this.runtime.sendDataToServer = false;
                }
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
            validateForm: function () {
                let returnMessage = false;

                this.runtime.postAdress.idPartner = this.runtime.idPartner;

                this.runtime.message = [];
                this.$check.validateForm(this.$refs);

                if( this.runtime.message.length>0 ){
                    this.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate");
                    this.$refs.validateWindowRef.setMessage(this.$app.getHtmlFormatMessage(this.runtime.message));
                    returnMessage = true;
                }
                return returnMessage;
            },
	        validateAdress: function (){
		        let value = this.$refs[this.INPUT_ADRESA.ref].getValue();
		        if(!this.$check.lenghtMinMax(value, this.INPUT_ADRESA.minLength, this.INPUT_ADRESA.maxLength)){
			        this.runtime.message.push(this.$app.getFormMessageClass(this.INPUT_ADRESA.id, this.INPUT_ADRESA.caption,
				        'trebuie sa aiba minim ' + this.INPUT_ADRESA.minLength + " si maxim " + this.INPUT_ADRESA.maxLength + " caractere"));
		        }

		        this.setPostAdress(this.INPUT_ADRESA, value);
            },
            validateLocalitate: function(){
                let value = this.$refs[this.INPUT_LOCALITATE.ref].getValue();

                let id = -1;

                if( this.$check.isUndef(value) || parseInt(value.id) < 1){
                    this.runtime.message.push(this.$app.getFormMessageClass(this.INPUT_LOCALITATE.id, this.INPUT_LOCALITATE.caption,
                        "Trebuie sa alegi localitatea"));
                }else{
                    id = value.id;
                }
                this.setPostAdress(this.INPUT_LOCALITATE, id);
            },
	        cfgLocalitate: function(){
		        let cfg = this.$app.cfgSelectSearch('nomLocalitati', this.$url.getUrl('nomLocalitati'), 220);
			        cfg.setValidateFunction(this.validateLocalitate);
			        cfg.setCaption("Localitate");
			        cfg.setMandatory(true);
			        return cfg;
            },

	        cfgAdresa: function(){
		        let cfg = this.$app.cfgInputField("adresa", 70, 600);
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
                captionButton: 'Modific adresa',
                form: {message: []},
                titleForm: 'titlu programing time ... '
            }
        }
    }

</script>

<style scoped></style>
