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

    <validate-window ref="refYesNoNew"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNoButtonNew"
    ></validate-window>

    <form-tab :ref = this.REF_FROM>
        <template v-slot:slotTitle>
            <div class="antet">
                <div class="buttons-container">
                    <div class="prime-button last-button">
                        <my-button  :ref=this.cfgtime.REF_BUTTON_ADD_CONT @click="this.setFormNew" :heightButton=22 :buttonType=2 title="adauga cont nou" :style="this.cfgtime.ICON_ADD_CONT.colorStyle">
                            <font-awesome-icon :icon=this.$constComponent.cfgIconPicture(this.cfgtime.ICON_ADD_CONT) size="1x" />
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
                        <label :for=this.cfgtime.INPUT_BANCA.id>{{this.cfgtime.INPUT_BANCA.caption}}</label></td>
                    <td class="control">
                        <input-field
                            :ref = this.cfgtime.INPUT_BANCA.ref
                            :pConfig = this.cfgtime.INPUT_BANCA
                        ></input-field>
                    </td>
                    <td class="label-left bold">
                        <label :for=this.cfgtime.INPUT_SUCURSALA.id>{{this.cfgtime.INPUT_SUCURSALA.caption}}</label></td>
                    <td class="control">
                        <input-field
                            :ref = this.cfgtime.INPUT_SUCURSALA.ref
                            :pConfig = this.cfgtime.INPUT_SUCURSALA
                        ></input-field>
                    </td>
                    <td class="control">

                        <div class="buttons">
                            &nbsp;
                            &nbsp;
                            <my-button :ref=this.cfgtime.REF_BUTTON_UPDATE_ACCOUNT @click="this.serverEditAccount" :heightButton=22 :buttonType=0 title="modific contul">{{this.captionRecordButton}}</my-button>
                        </div>
                    </td>
                </tr>
                <td class="label-left bold">
                    <label>IBAN</label></td>
                <td class="control">
                    <my-iban
                        :ref = this.cfgtime.INPUT_IBAN.ref
                        :pConfig = this.cfgtime.INPUT_IBAN
                    ></my-iban>
                </td>
                <tr>

                </tr>
            </table>
            <br>

            <my-list
                :ref = this.cfgtime.REF_LISTA_BANK
                :pConfig=this.cfgtime.cfgListaBank
                @emitContImplicit = "emitContImplicit"
                @emitListRowSelection = 'emitListBankRowSelection'
            ></my-list>
        </template>

        <template v-slot:slotButton>
        </template>

    </form-tab>
</template>

<script>
    import AlertWindow      from "@/components/base/AlertWindow.vue";
    import FormTab          from "@/components/base/FormTab.vue";
    import Button           from "@/components/base/Button";
    import Iban             from "@/components/base/Iban.vue";
    import Lista            from "@/components/base/Lista";
    import InputField       from "@/components/base/InputField.vue";

    export default {
        components: {
            'form-tab': FormTab,
            'validate-window': AlertWindow,
            'my-button': Button,
            'my-iban': Iban,
            'my-list': Lista,
            'input-field': InputField
        },
        name: "form-partener-banc_acount",
        created() {
            this.REF_FROM = 'refForm';
            this.REF_LISTA_BANC_COUNT = 'refListaBancCount';
	        this.runtime = {
                mode: this.$constFROM.MODE_EDIT,
                sendDataToServer: false,
	            showModalLoadingDiv: false,
	            message: [],
                idPartner: -1,
                post: { idPk: null, field: {}, sqlAction: null},
	            postAccount: {idPk: null, idPartner: null, sqlAction: null, field: {}},
                selectRecordFromLista: {idPk: null, banca: null, sucursala: null, iban: null}
            };
            this.cfgtime = {
                REF_BUTTON_ADD_CONT: 'refButtonAddCont',
                REF_LISTA_BANK: 'refListaCountBank',
                REF_BUTTON_UPDATE_ACCOUNT: 'refButtonUpdateAccount',
                ICON_ADD_CONT: this.$constComponent.ICON_PLUS_SQUARE("blue"),
                URL_SET_DEFAULT_ACCOUNT: this.$url.getUrl('partenerSetBancCont'),
                INPUT_BANCA: this.cfgBanca(),
                INPUT_SUCURSALA: this.cfgSucursala(),
                INPUT_IBAN: this.cfgInputIBAN(),
                cfgListaBank: {
                    header: [
                        this.$constList.getHeader(1, 'Banca', 500, 'cBanca', this.$constList.HEADER.CAPTION_TYPE_FIELD ),
                        this.$constList.getHeader(2, 'Sucursala', 500, 'cSucursala', this.$constList.HEADER.CAPTION_TYPE_FIELD ),
                        this.$constList.getHeader(3, 'IBAN', 10, 'cIBAN', this.$constList.HEADER.CAPTION_TYPE_FIELD ),
                        this.$constList.getHeader(4, 'Adresa implicita', 10, 'null', this.$constList.HEADER.CAPTION_TYPE_ACTION)
                    ],
                    recordActionButon: [
                        // this.$constList.getActionButton(4, 'adresa implicita', 'emitButton', this.$constGrid.getIcon('fas','skull', '#adad00'), this.$constList.ACTION_BUTTON.TYPE_BUTTON, null),
                        this.$constList.getActionButton(5, 'cont implicit', 'emitContImplicit', null, this.$constList.ACTION_BUTTON.TYPE_CHECKBOX, this.$app.cfgCheckBox('contActiv', false))   // poate fi un singur checkbox pe linie, trebuie setat si filedNameForCheckBox, campul poate fi doar 1 si 0
                        // this.$constList.getActionButton(4, 'adresa implicita', 'emitCheckBox', this.$constGrid.getIcon('fas','skull', '#adad00')),
                    ],
                    cfg: { urlData: 'partenerListBancCont', loadOnCreate: false, filedNameForCheckBox: 'activ', emitListRowSelection: 'emitListRowSelection'}
                },
            };
        },
        emits: ['emitNewRecord'],
        mounted () {
        },
        methods: {
            setFormNew: function(){
                this.privateSetModeForm(this.$constFROM.MODE_NEW);
            },
            showList: function (postData){
                this.privateFillFormReset();
                this.$refs[this.cfgtime.REF_LISTA_BANK].showList(postData);

                this.privateSetModeForm(this.$constFROM.MODE_EDIT);
                this.$refs[this.cfgtime.REF_BUTTON_UPDATE_ACCOUNT].disable(true);

            },
            setIdAndTitle: function (title, idPk){
                this.runtime.idPartner = idPk;
                this.titleForm =  title;
            },
            serverEditAccount: function (){
                if(this.validateForm()){
                    this.$refs.validateWindowRef.show();
                    return false;
                }

                if(!this.runtime.sendDataToServer){

                    let msg = "nimic";

                    if(this.runtime.mode == this.$constFROM.MODE_EDIT){
                        msg = "Editez contul ?";
                    }else if(this.runtime.mode == this.$constFROM.MODE_NEW){
                        msg = "Adaug contul ? <br> Contul nou devine automat contul implicit.";
                    }

                    this.$refs.refYesNoNew.setCaption("Adresa");
                    this.$refs.refYesNoNew.setMessage(msg);
                    this.$refs.refYesNoNew.show();
                }
            },
            serverCheckAccount: function (){
                if(!this.runtime.sendDataToServer){
                    this.$refs.refYesNo.setCaption("Cont partener");
                    this.$refs.refYesNo.setMessage("Activez contul bancar selectat?");
                    this.$refs.refYesNo.show();
                }

                if(this.runtime.sendDataToServer){
                        this.runtime.sendDataToServer = false;
                        this.axios
                            .post(this.cfgtime.URL_SET_DEFAULT_ACCOUNT, this.runtime.postAccount)
                            .then(response => {
                                if (response.data.succes){
                                    this.runtime.showModalLoadingDiv = true;
                                }
                                else {
                                    this.$refs.validateWindowRef.setCaption("Contul nu poate fi setat");
                                    this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
                                    this.$refs.validateWindowRef.show();
                                }
                            })
                            .catch(error => console.log(error))
                            .finally(() => {
                                this.runtime.showModalLoadingDiv = false;
                                this.showList({idPartner: this.runtime.postAccount.idPartner});
                            });
                 }
            },
            privateSetPostAccount: function (component, value){
                this.runtime.postAccount['field'][component.name] = value;

            },
            privateFillForm: function () {
                this.$refs[this.cfgtime.INPUT_BANCA.ref].setValue(this.runtime.selectRecordFromLista.banca);
                this.$refs[this.cfgtime.INPUT_SUCURSALA.ref].setValue(this.runtime.selectRecordFromLista.sucursala);
                this.$refs[this.cfgtime.INPUT_IBAN.ref].setValue(this.runtime.selectRecordFromLista.iban);
            },
            privateFillFormReset: function () {
                this.runtime.selectRecordFromLista.banca = '';
                this.runtime.selectRecordFromLista.sucursala = '';
                this.runtime.selectRecordFromLista.iban ='';

                this.privateFillForm();
            },
            privateSetModeForm: function (mode){
                this.runtime.mode = mode;

                if(this.runtime.mode == this.$constFROM.MODE_EDIT){
                    this.runtime.postAccount.sqlAction = this.$constComponent.SQL_UPDATE;
                    this.$refs[this.cfgtime.REF_BUTTON_UPDATE_ACCOUNT].disable(false);
                    this.captionRecordButton = "Modific contul";
                    this.$refs[this.cfgtime.REF_BUTTON_ADD_CONT].disable(false);
                }

                if(this.runtime.mode == this.$constFROM.MODE_NEW){
                    this.$refs[this.cfgtime.REF_BUTTON_ADD_CONT].disable(true);
                    this.runtime.postAccount.sqlAction = this.$constComponent.SQL_INSERT;
                    this.captionRecordButton = "Adaug cont";
                    this.privateFillFormReset();
                    this.$refs[this.cfgtime.REF_BUTTON_UPDATE_ACCOUNT].disable(false);
                }

            },
            emitListBankRowSelection: function (target){
                if(target.tagName == 'DIV'){
                    // console.log(target.parentNode);
                    let tr = target.closest('tr');

                    for(let i=0;i<tr.children.length;i++){
                        if(tr.children[i].getAttribute('field') == 'cBanca'){
                            this.runtime.selectRecordFromLista.banca = tr.children[i].firstChild.textContent;
                        }else if(tr.children[i].getAttribute('field') == 'cSucursala'){
                            this.runtime.selectRecordFromLista.sucursala = tr.children[i].firstChild.textContent;
                        }else if(tr.children[i].getAttribute('field') == 'cIBAN') {
                            this.runtime.selectRecordFromLista.iban = tr.children[i].firstChild.textContent;
                        }
                    }


                    // runtime data selected form list
                    this.runtime.selectRecordFromLista.idPk = tr.getAttribute('idPk');
                    this.runtime.postAccount.idPk = this.runtime.selectRecordFromLista.idPk;

                    this.privateSetModeForm(this.$constFROM.MODE_EDIT);

                    this.privateFillForm();
                }
            },
            emitContImplicit: function (checkBoxControl){

                this.runtime.postAccount.idPk = checkBoxControl.getAttribute("idPk");
                this.runtime.postAccount.idPartner = this.runtime.idPartner;

                if(!checkBoxControl.checked){
                    // este deja bifat, nu fac nimic, refac bifa;
                    checkBoxControl.checked = true;
                } else {
                    checkBoxControl.checked = false;
                    this.serverCheckAccount();
                }

            },
            emitYesNoButtonNew: function (yes) {
                if(yes == 1){
                    this.runtime.sendDataToServer = true;
                    // this.serverEditAdress();
                }else{
                    this.runtime.sendDataToServer = false;
                }
            },
            emitYesNoButton: function (yes) {
                if(yes == 1){
                    this.runtime.sendDataToServer = true;
	                this.serverCheckAccount();
                }else{
                    this.runtime.sendDataToServer = false;
                }
            },
	        setPostBankCount: function (component, value){
    	        this.runtime.postAdress['field'][component.name] = value;

	        },
            validateForm: function () {
                let returnMessage = false;
                this.runtime.message = [];
                this.$check.validateForm(this.$refs);

                if( this.runtime.message.length>0 ){
                    this.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate");
                    this.$refs.validateWindowRef.setMessage(this.$app.getHtmlFormatMessage(this.runtime.message));
                    returnMessage = true;
                }
                return returnMessage;
            },
            validateBanca: function (){
                let obj = this.cfgtime.INPUT_BANCA;
                let value = this.$refs[obj.ref].getValue();

                if(!this.$check.lenghtMinMax(value, obj.minLength, obj.maxLength)){
                    this.runtime.message.push(this.$app.getFormMessageClass(obj.id, obj.caption,
                        'trebuie sa aiba minim ' + obj.minLength + " si maxim " + obj.maxLength + " caractere"));
                }
                this.privateSetPostAccount(obj, value);
            },
            validateSucursala: function (){
                let obj = this.cfgtime.INPUT_SUCURSALA;
                let value = this.$refs[obj.ref].getValue();

                if(!this.$check.lenghtMinMax(value, obj.minLength, obj.maxLength)){
                    this.runtime.message.push(this.$app.getFormMessageClass(obj.id, obj.caption,
                        'trebuie sa aiba minim ' + obj.minLength + " si maxim " + obj.maxLength + " caractere"));
                }

                this.privateSetPostAccount(obj, value);
            },
            validateIban: function (){
                let obj = this.cfgtime.INPUT_IBAN;
                let value = this.$refs[obj.ref].getValue();
                let checkCode = this.$check.checkCode( this.$constBussines.RO_IBAN ,value);
                if(!checkCode){
                    this.runtime.message.push(this.$app.getFormMessageClass(obj.id, obj.caption,
                        " Cont IBAN incorect!"));
                }
                this.privateSetPostAccount(obj, value);
            },
            cfgBanca: function(){
                let cfg = this.$app.cfgInputField("banca", 50);
                cfg.setValidate(1,30);
                cfg.setValidateFunction(this.validateBanca);
                cfg.setCaption("Banca");
                cfg.setMandatory(true);
                cfg.setMaska("");
                return cfg;
            },
            cfgSucursala: function(){
                let cfg = this.$app.cfgInputField("sucursala", 60);
                cfg.setValidate(1,30);
                cfg.setValidateFunction(this.validateSucursala);
                cfg.setCaption("Sucursala");
                cfg.setMandatory(true);
                cfg.setMaska("");
                return cfg;
            },
            cfgInputIBAN: function(){
                let cfg = this.$app.cfgInputIBAN("inputIban", null);
                cfg.setValidateFunction(this.validateIban);
                cfg.setCaption("IBAN");
                cfg.setMandatory(true);
                return cfg;
            }
        },
        data () {
            return {
                captionRecordButton: 'Modific contul',
                titleForm: 'titlu programing time ... '
            }
        }
    }

</script>

<style scoped></style>
